<?php

namespace Mesd\SettingsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Mesd\SettingsBundle\Model\SettingManager;

class CreateHiveCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('mesd:setting:hive:create')
            ->setDescription('Create a hive.')
            ->setDefinition(array(
                new InputArgument('name', InputArgument::REQUIRED, 'Hive Name'),
                new InputArgument('description', InputArgument::OPTIONAL, 'Hive Description'),
                new InputOption('definedAtHive', null, InputOption::VALUE_NONE, 'Set the definition level to hive'),
                new InputOption('noDefine', null, InputOption::VALUE_NONE, 'Do not ask to define settings'),
              ))
            ->setHelp(<<<EOT
The <info>mesd:setting:hive:create</info> command creates a setting hive:

This interactive shell will ask you for a name and description.

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name          = $input->getArgument('name');
        $description   = $input->getArgument('description');
        $definedAtHive = $input->getOption('definedAtHive');
        $noDefine      = $input->getOption('noDefine');

        // If user did not specify definition level at command execution,
        // ask the user now.
        if (!$definedAtHive) {
            $definedAtHive =
                $this->getHelper('dialog')->askAndValidate(
                    $output,
                    'Should settings be defined at hive? (No):',
                    function($definedAtHive) {
                        if (empty($definedAtHive) || !in_array(strtolower($definedAtHive), array('y', 'yes', 'n', 'no'))) {
                            throw new \Exception('Please answer yes or no');
                        }
                        elseif (in_array(strtolower($definedAtHive), array('y', 'yes'))) {
                            return true;
                        }
                        else  {
                            return false;
                        }
                    },
                    false,
                    'n'
                );
        }

        $settingManager =  $this->getContainer()->get("mesd_settings.setting_manager");

        // If hive already exists, throw error
        if ($settingManager->hiveExists($name)) {
            $output->writeln(sprintf('<error>Error: Hive %s already exists</error>', $name));
            exit;
        }
        else {
            $settingManager->createHive($name, $description, $definedAtHive);
            $output->writeln(sprintf('<comment>Created hive <info>%s</info></comment>', $name));
        }

        // If settings are not defined at hive, offer to create cluster.
        if (!$definedAtHive) {
            $createCluster =
                $this->getHelper('dialog')->askAndValidate(
                    $output,
                    'Would you like to create a new cluster? (No):',
                    function($createCluster) {
                        if (empty($createCluster) || !in_array(strtolower($createCluster), array('y', 'yes', 'n', 'no'))) {
                            throw new \Exception('Please answer yes or no');
                        }
                        elseif (in_array(strtolower($createCluster), array('y', 'yes'))) {
                            return true;
                        }
                        else  {
                            return false;
                        }
                    },
                    false,
                    'n'
                );

            // If user requested, run create cluster command now.
            if ($createCluster) {
                $command = $this->getApplication()->find('mesd:setting:cluster:create');
                $arguments = array(
                    'command'  => 'mesd:setting:cluster:create',
                    'hiveName' => $name,
                );
                $input = new ArrayInput($arguments);
                $returnCode = $command->run($input, $output);
            }
        }
        // If user did not request to ignore setting definition at command line,
        // offer to define hive settings now.
        elseif (!$noDefine) {
            $defineSetting =
                $this->getHelper('dialog')->askAndValidate(
                    $output,
                    'Would you like to define a new setting? (No):',
                    function($defineSetting) {
                        if (empty($defineSetting) || !in_array(strtolower($defineSetting), array('y', 'yes', 'n', 'no'))) {
                            throw new \Exception('Please answer yes or no');
                        }
                        elseif (in_array(strtolower($defineSetting), array('y', 'yes'))) {
                            return true;
                        }
                        else  {
                            return false;
                        }
                    },
                    false,
                    'n'
                );

            // If user requested, run define setting command
            if ($defineSetting) {
                $command = $this->getApplication()->find('mesd:setting:setting:define');
                $arguments = array(
                    'command'  => 'mesd:setting:setting:define',
                    'hiveName' => $name
                );
                $input = new ArrayInput($arguments);
                $returnCode = $command->run($input, $output);
            }
        }
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('name')) {
            $name = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a hive name:',
                function($name) {
                    if (empty($name)) {
                        throw new \Exception('Hive name can not be empty');
                    }

                    return $name;
                }
            );
            $input->setArgument('name', $name);
        }

        if (!$input->getArgument('description')) {
            $description = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please enter a description [optional]:',
                function($description) {
                    if (empty($description)) {
                        return null;
                    }
                    return $description;
                }
            );
            $input->setArgument('description', $description);
        }

    }
}
