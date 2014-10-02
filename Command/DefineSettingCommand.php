<?php

namespace Fc\SettingsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Fc\SettingsBundle\Model\SettingManager;

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
        $hiveName = $input->getArgument('hiveName');

        $settingManager    = $this->getContainer()->get("fc_settings.setting_manager");
        $definitionManager = $this->getContainer()->get("fc_settings.definition_manager");

        // If Hive doesn't exist, exit now so user can create it
        if (!$hive = $settingManager->hiveExists($hiveName)) {
            $output->writeln(sprintf('<error>Error: Hive %s does not exist</error>', $hiveName));
            exit;
        }


        // If settings are defined at hive, no cluster is needed.
        if ($hive->getDefinedAtHive()) {
            $fileName = $definitionManager
                ->buildFileName($hiveName);
        }
        // If settings are not defined at hive, we must request which cluster.
        else {
            $dialog = $this->getHelper('dialog');
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
            $output->writeln('<comment>Definition file was not found!</comment>');
            $dialog = $this->getHelper('dialog');
            $createFile = $dialog->askConfirmation(
                $output,
                '<question>Would you like to create a new definition file? (y/n) :<question>',
                false
            );

            if($createFile) {
                echo "Createing File! \n";
            }
            else {
                $output->writeln(
                    sprintf(
                        '<comment>Please create a %s definition file to define settings.</comment>',
                        $fileName
                    )
                );
                exit;
            }


        }




        /*else {
            $settingManager->createHive($name, $description, $definedAtHive);
            $output->writeln(sprintf('<comment>Created hive <info>%s</info></comment>', $name));
        }*/
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('hiveName')) {
            $hiveName = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please enter the hive name:',
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
}