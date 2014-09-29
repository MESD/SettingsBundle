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
                new InputArgument('hive', InputArgument::REQUIRED, 'Hive Name'),
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
        $hive          = $input->getArgument('hive');

        $settingManager =  $this->getContainer()->get("fc_settings.setting_manager");

        if (!$settingManager->hiveExists($hive)) {
            $output->writeln(sprintf('<error>Error: Hive %s does not exist</error>', $hive));
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
        if (!$input->getArgument('hive')) {
            $hive = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please enter the hive name:',
                function($hive) {
                    if (empty($hive)) {
                        throw new \Exception('Hive name can not be empty');
                    }

                    return $hive;
                }
            );
            $input->setArgument('hive', $hive);
        }
    }
}