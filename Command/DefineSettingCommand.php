<?php

namespace Mesd\SettingsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\DialogHelper;
use Mesd\SettingsBundle\Model\Definition\SettingDefinition;
use Mesd\SettingsBundle\Model\Definition\SettingNode;

class DefineSettingCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('mesd:setting:setting:define')
            ->setDescription('Define a setting.')
            ->setDefinition(array(
                new InputArgument('hiveName', InputArgument::REQUIRED, 'Hive Name'),
              ))
            ->setHelp(<<<EOT
The <info>mesd:setting:setting:define</info> command defines a setting:

This interactive shell will ask you for a setting details.

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get user input
        $hiveName = $input->getArgument('hiveName');

        // Get needed services
        $settingManager    = $this->getContainer()->get("mesd_settings.setting_manager");
        $definitionManager = $this->getContainer()->get("mesd_settings.definition_manager");

        // Get Dialog Helper
        $dialog = $this->getHelper('dialog');

        // If the specified Hive doesn't exist, exit now so user can create it
        if (!$hive = $settingManager->hiveExists($hiveName)) {
            $output->writeln(sprintf('<error>Error: Hive %s does not exist</error>', $hiveName));
            exit;
        }

        // If settings are defined at hive, no cluster is needed.
        if ($hive->getDefinedAtHive()) {
            $clusterName = null;
            $fileName = $definitionManager
                ->buildFileName($hiveName);
        }
        // If settings are not defined at hive, we must request a cluster.
        else {
            $clusterName = $dialog->askAndValidate(
                $output,
                'Please enter the cluster name:',
                function($clusterName) {
                    if (empty($clusterName)) {
                        throw new \Exception('Cluster name can not be empty');
                    }

                    return $clusterName;
                }
            );

            // If Cluster doesn't exist, exit now so user can create it.
            if (!$cluster = $settingManager->clusterExists($hiveName, $clusterName)) {
                $output->writeln(
                    sprintf(
                        '<error>Error: Hive %s and Cluster %s combination do not exist</error>',
                        $hiveName,
                        $clusterName
                    )
                );
                exit;
            }

            $fileName = $definitionManager
                ->buildFileName($hiveName, $clusterName);
        }

        // If definition file does not exist, ask user if they want
        // to create the file.
        if (!$definitionManager->locateFile($fileName)) {
            $output->writeln(array(
                '',
                '<comment>Definition file was not found!</comment>',
                ''
            ));
            $createFile = $dialog->askConfirmation(
                $output,
                'Would you like to create a new definition file? (y/n): ',
                false
            );

            $output->writeln('');

            // If user requested the file be created, create a new definition and
            // save file.
            if($createFile) {

                // Get list of setting file storage locations currently configured
                $availableLocations = $definitionManager->getBundleStorage();

                $fileLocation = $dialog->select(
                    $output,
                    'Please select location to store the Setting Definition (Default - 0):',
                    $availableLocations,
                    0
                );

                $settingDefinition = new SettingDefinition();
                $settingDefinition->setHive($hiveName);

                if ($hive->getDefinedAtHive()) {
                    $settingDefinition->setKey($hiveName);
                    $settingDefinition->setType('hive');
                }
                else {
                    $settingDefinition->setKey($clusterName);
                    $settingDefinition->setType('cluster');
                }

                $settingDefinition->setFilePath($availableLocations[$fileLocation]);

                $file = $definitionManager->saveFile($settingDefinition);
                $output->writeln(array(
                    '',
                    sprintf('<info>Definition file %s created.</info>', $file),
                    ''
                ));
            }
            else {
                $output->writeln(array(
                    '',
                    sprintf(
                        '<comment>Please create a %s definition file before defining settings.</comment>',
                        $fileName
                    ),
                    ''
                ));
                exit;
            }
        }
        // Load SettingDefinition from existing definition file
        else {
            $settingDefinition = $definitionManager->loadFile($hiveName, $clusterName);
        }

        // Define setting loop - Allow user to define as many settings as needed
        $count = 1;
        while(true) {

            $output->writeln(array(
                '',
                '<comment>Define as many settings as needed. Enter "e" or press <return> when done.</comment>',
                ''
            ));

            // Request what type of SettingNode to create
            $settingTypes = array(
                'a' => 'Array',
                'b' => 'Boolean',
                'f' => 'Float',
                'i' => 'Integer',
                's' => 'String',
                'e' => 'Exit'
            );
            $settingType = $dialog->select(
                $output,
                'Please select setting type (press <return> to stop defining settings): ',
                $settingTypes,
                'e'
            );

            // If user is done, break out of loop
            if('e' === $settingType) {
                break;
            }

            // Request setting node name
            $nodeName = $dialog->askAndValidate(
                $output,
                'Please enter the setting name: ',
                function($nodeName) {
                    if (empty($nodeName)) {
                        throw new \Exception('Setting name can not be empty');
                    }

                    return $nodeName;
                }
            );

            // Check if setting already exisits. If yes, ask user
            // if they want to overwrite.
            if ($settingDefinition->getSettingNode($nodeName)) {

                $output->writeln('');

                $overwrite = $dialog->askConfirmation(
                    $output,
                    sprintf(
                        '<comment>Setting %s already exisits. Would you like to overwrite? (y/n):</comment> ',
                        $nodeName
                    ),
                    false
                );

                // If user doesn't want to overwite, then start again with a new setting.
                if(!$overwrite) {
                    continue;
                }
            }

            // Request setting node description
            $nodeDesc = $dialog->ask(
                $output,
                'Please enter the setting description [optional]: ',
                null
            );

            // Request setting node attribute data for specific setting type
            $settingNodeMethod = 'RequestNodeData' . $settingTypes[$settingType];
            $settingNodeAttributes = $this->$settingNodeMethod($input, $output, $dialog);

            // Add setting description to node attributes
            $settingNodeAttributes['description'] = $nodeDesc;

            // Store setting node data in expected array format
            $nodeData = array (
                'nodeName' => $nodeName,
                'nodeAttributes' => $settingNodeAttributes
            );

            // Define a new setting node using array of node data
            $settingNode = new SettingNode($nodeData);

            // Add SettingNode to SettingDefinition
            $settingDefinition->addSettingNode($settingNode);

            $output->writeln(array(
                '',
                sprintf(
                    '<comment>%d setting(s) defined.</comment>',
                    $count
                )
            ));

            $count++;
        }

        // Save SettingDefinition to file
        $file = $definitionManager->saveFile($settingDefinition);

        $output->writeln(array(
            '',
            sprintf('<info>Setting definition saved to file %s</info>', $file),
            ''
        ));

    }


    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('hiveName')) {
            $hiveName = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please enter the hive name: ',
                function($hiveName) {
                    if (empty($hiveName)) {
                        throw new \Exception('Hive name can not be empty');
                    }

                    return $hiveName;
                }
            );
            $input->setArgument('hiveName', $hiveName);
        }
    }


    /**
     * Request data needed for new Array Setting Node
     *
     * @param InputInterface
     * @param OutputInterface
     * @param DialogHelper
     * @param string $nodeName
     * @param string $nodeDesc
     *
     * @return SettingNode
     */
    protected function RequestNodeDataArray(InputInterface $input, OutputInterface $output, DialogHelper $dialog)
    {

        // Request prototype for array setting
        $prototypes = array(
            'b' => 'Boolean',
            'f' => 'Float',
            'i' => 'Integer',
            's' => 'String'
        );
        $settingPrototype = $dialog->select(
            $output,
            'Please select a prototype for your array setting (String): ',
            $prototypes,
            's'
        );

        // Request setting data for specific prototype
        $prototypeMethod = 'RequestNodeData' . $prototypes[$settingPrototype];
        $prototypeAttributes = $this->$prototypeMethod($input, $output, $dialog, $prototype = true);

        // Array defualt value loop - Allow user to define as many
        // default values as needed.
        $defaultValueList = array();
        $count = 1;
        while(true) {

            $output->writeln(array(
                '',
                sprintf(
                    '<comment>Define as many %s default values as needed. Press <return> when done.</comment>',
                    $prototypeAttributes['type']
                ),
                ''
            ));

            $defaultValue = $dialog->ask(
                $output,
                'Please enter the default value [optional]: ',
                null
            );

            // If user is done, break out of loop
            if(!$defaultValue) {
                break;
            }

            $defaultValueList[] = $defaultValue;

            $output->writeln(array(
                '',
                sprintf(
                    '<comment>%d default value(s) defined.</comment>',
                    $count
                )
            ));

            $count++;
        }

        // Store setting node data in expected array format
        $nodeAttributes = array (
            'type'      => 'array',
            'prototype' => $prototypeAttributes,
            'default'   => $defaultValueList
        );

        return $nodeAttributes;
    }


    /**
     * Request data needed for new Boolean Setting Node
     *
     * @param InputInterface
     * @param OutputInterface
     * @param DialogHelper
     * @param string $nodeName
     * @param string $nodeDesc
     *
     * @return SettingNode
     */
    protected function RequestNodeDataBoolean(InputInterface $input, OutputInterface $output, DialogHelper $dialog, $prototype = false)
    {
        // Store setting node data in expected array format
        $nodeAttributes = array (
            'type'        => 'boolean'
        );

        // Request default value if this is not an array prototype
        if (false === $prototype) {
            $defaultTypes = array('false', 'true');
            $defaultValue = $dialog->select(
                $output,
                'Please select setting default value (False): ',
                $defaultTypes,
                false
            );
            $nodeAttributes['default'] = filter_var($defaultValue, FILTER_VALIDATE_BOOLEAN);
        }

        return $nodeAttributes;
    }


    /**
     * Request data needed for new Float Setting Node
     *
     * @param InputInterface
     * @param OutputInterface
     * @param DialogHelper
     * @param string $nodeName
     * @param string $nodeDesc
     *
     * @return SettingNode
     */
    protected function RequestNodeDataFloat(InputInterface $input, OutputInterface $output, DialogHelper $dialog, $prototype = false)
    {
        // Request setting digits
        $digits = $dialog->askAndValidate(
            $output,
            'Please enter the setting values max number of digits: ',
            function($digits) {
                if (empty($digits)) {
                    throw new \Exception('Max digits can not be empty');
                }
                if ( 1 > intval($digits)) {
                    throw new \Exception('Max digits must be a positive integer');
                }

                return $digits;
            }
        );

        // Request setting precision
        $precision = $dialog->askAndValidate(
            $output,
            'Please enter the setting values precision: ',
            function($precision) {
                if (empty($precision)) {
                    throw new \Exception('Precision can not be empty');
                }
                if ( 1 > intval($precision)) {
                    throw new \Exception('Precision must be a positive integer');
                }

                return $precision;
            }
        );

        // Store setting node data in expected array format
        $nodeAttributes = array (
            'type'      => 'float',
            'digits'    => intval($digits),
            'precision' => intval($precision)
        );

        // Request default value if this is not an array prototype
        if (false === $prototype) {
            $defaultValue = $dialog->ask(
                $output,
                'Please enter the default value [optional]: ',
                null
            );
            $nodeAttributes['default'] = floatval($defaultValue);
        }

        return $nodeAttributes;
    }


    /**
     * Request data needed for new Integer Setting Node
     *
     * @param InputInterface
     * @param OutputInterface
     * @param DialogHelper
     * @param string $nodeName
     * @param string $nodeDesc
     *
     * @return SettingNode
     */
    protected function RequestNodeDataInteger(InputInterface $input, OutputInterface $output, DialogHelper $dialog, $prototype = false)
    {
        // Request setting digits
        $digits = $dialog->askAndValidate(
            $output,
            'Please enter the setting values max number of digits: ',
            function($digits) {
                if (empty($digits)) {
                    throw new \Exception('Max digits can not be empty');
                }
                if ( 1 > intval($digits)) {
                    throw new \Exception('Max digits must be a positive integer');
                }

                return $digits;
            }
        );

        // Store setting node data in expected array format
        $nodeAttributes = array (
            'type'      => 'integer',
            'digits'    => intval($digits)
        );

        // Request default value if this is not an array prototype
        if (false === $prototype) {
            $defaultValue = $dialog->ask(
                $output,
                'Please enter the default value [optional]: ',
                null
            );
            $nodeAttributes['default'] = intval($defaultValue);
        }

        return $nodeAttributes;
    }


    /**
     * Request data needed for new String Setting Node
     *
     * @param InputInterface
     * @param OutputInterface
     * @param DialogHelper
     * @param string $nodeName
     * @param string $nodeDesc
     *
     * @return SettingNode
     */
    protected function RequestNodeDataString(InputInterface $input, OutputInterface $output, DialogHelper $dialog, $prototype = false)
    {
        // Request setting max length
        $maxLength = $dialog->askAndValidate(
            $output,
            'Please enter the setting values max length: ',
            function($maxLength) {
                if (empty($maxLength)) {
                    throw new \Exception('Max length can not be empty');
                }
                if ( 1 > intval($maxLength)) {
                    throw new \Exception('Max length must be a positive integer');
                }

                return $maxLength;
            }
        );

        // Store setting node data in expected array format
        $nodeAttributes = array (
            'type'    => 'string',
            'length'  => intval($maxLength)
        );

        // Request default value if this is not an array prototype
        if (false === $prototype) {
            $defaultValue = $dialog->ask(
                $output,
                'Please enter the default value [optional]: ',
                null
            );
            $nodeAttributes['default'] = $defaultValue;
        }

        return $nodeAttributes;
    }

}