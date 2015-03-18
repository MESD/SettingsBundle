<?php

namespace Mesd\SettingsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
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

        // If user did not specify definition level at command execution,
        // ask the user now.
        if (!$definedAtHive) {
            $definedAtHive = $this->getHelper('dialog')->askAndValidate(
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

        if ($settingManager->hiveExists($name)) {
            $output->writeln(sprintf('<error>Error: Hive %s already exists</error>', $name));
        }
        else {
            $settingManager->createHive($name, $description, $definedAtHive);
            $output->writeln(sprintf('<comment>Created hive <info>%s</info></comment>', $name));
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