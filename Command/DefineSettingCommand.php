<?php

namespace Fc\SettingsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\DialogHelper;
use Fc\SettingsBundle\Model\Definition\SettingDefinition;
use Fc\SettingsBundle\Model\Definition\SettingNode;

class DefineSettingCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('fc:setting:setting:define')
            ->setDescription('Define a setting.')
            ->setDefinition(array(
                new InputArgument('hiveName', InputArgument::REQUIRED, 'Hive Name'),
              ))
            ->setHelp(<<<EOT
The <info>fc:setting:setting:define</info> command defines a setting:

This interactive shell will ask you for a  and description.

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
        $settingManager    = $this->getContainer()->get("fc_settings.setting_manager");
        $definitionManager = $this->getContainer()->get("fc_settings.definition_manager");

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

            // If user requested the file be created, create a new definition and
            // save file.
            if($createFile) {
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

        // Allow user to define as many settings as needed
        while(true) {

            // Request what type of SettingNode to create
            $settingTypes = array('Array', 'Boolean', 'Float', 'Integer', 'String');
            $settingType = $dialog->select(
                $output,
                'Please select setting type (press <return> to stop defining settings): ',
                $settingTypes,
                false
            );

            // If user is done, break out of loop
            if(!$settingType) {
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

            // Request setting node description
            $nodeDesc = $dialog->ask(
                $output,
                'Please enter the setting description [optional]: ',
                null
            );

            // Reuest SettingNode data for specific type of setting
            $settingNodeMethod = 'RequestNodeData' . $settingTypes[$settingType];
            $settingNode = $this->$settingNodeMethod($input, $output, $dialog, $nodeName, $nodeDesc);

            // Add SettingNode to SettingDefinition
            $settingDefinition->addSettingNode($settingNode);

        }

        // Save SettingDefinition to file
        $definitionManager->saveFile($settingDefinition);
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
    protected function RequestNodeDataBoolean(InputInterface $input, OutputInterface $output, DialogHelper $dialog, $nodeName, $nodeDesc)
    {

        // Request default value
        $defaultTypes = array('false', 'true');
        $defaultValue = $dialog->select(
            $output,
            'Please select setting default value (False): ',
            $defaultTypes,
            false
        );

        // Store setting node data in expected array format
        $nodeData = array (
            'nodeName' => $nodeName,
            'nodeAttributes' => array (
                'type'        => 'boolean',
                'default'     => $defaultValue,
                'description' => $nodeDesc
            )
        );

        // Define a new setting node using array of node data
        $settingNode = new SettingNode($nodeData);

        return $settingNode;
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
    protected function RequestNodeDataFloat(InputInterface $input, OutputInterface $output, DialogHelper $dialog, $nodeName, $nodeDesc)
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

        // Request default value
        $defaultValue = $dialog->ask(
            $output,
            'Please enter the default value [optional]: ',
            null
        );

        // Store setting node data in expected array format
        $nodeData = array (
            'nodeName' => $nodeName,
            'nodeAttributes' => array (
                'type'        => 'float',
                'digits'      => intval($digits),
                'precision'   => intval($precision),
                'default'     => floatval($defaultValue),
                'description' => $nodeDesc
            )
        );

        // Define a new setting node using array of node data
        $settingNode = new SettingNode($nodeData);

        return $settingNode;
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
    protected function RequestNodeDataInteger(InputInterface $input, OutputInterface $output, DialogHelper $dialog, $nodeName, $nodeDesc)
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

        // Request default value
        $defaultValue = $dialog->ask(
            $output,
            'Please enter the default value [optional]: ',
            null
        );

        // Store setting node data in expected array format
        $nodeData = array (
            'nodeName' => $nodeName,
            'nodeAttributes' => array (
                'type'        => 'integer',
                'digits'      => intval($digits),
                'default'     => intval($defaultValue),
                'description' => $nodeDesc
            )
        );

        // Define a new setting node using array of node data
        $settingNode = new SettingNode($nodeData);

        return $settingNode;
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
    protected function RequestNodeDataString(InputInterface $input, OutputInterface $output, DialogHelper $dialog, $nodeName, $nodeDesc)
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

        // Request default value
        $defaultValue = $dialog->ask(
            $output,
            'Please enter the default value [optional]: ',
            null
        );

        // Store setting node data in expected array format
        $nodeData = array (
            'nodeName' => $nodeName,
            'nodeAttributes' => array (
                'type'        => 'string',
                'length'      => intval($maxLength),
                'default'     => $defaultValue,
                'description' => $nodeDesc
            )
        );

        // Define a new setting node using array of node data
        $settingNode = new SettingNode($nodeData);

        return $settingNode;
    }

}