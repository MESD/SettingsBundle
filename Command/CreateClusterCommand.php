<?php

namespace Mesd\SettingsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Mesd\SettingsBundle\Model\SettingManager;

class CreateClusterCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('mesd:setting:cluster:create')
            ->setDescription('Create a cluster.')
            ->setDefinition(array(
                new InputArgument('name', InputArgument::REQUIRED, 'Cluster Name'),
                new InputArgument('description', InputArgument::OPTIONAL, 'Cluster Description'),
                new InputArgument('hiveName', InputArgument::OPTIONAL, 'Hive name to attach Cluster'),
              ))
            ->setHelp(<<<EOT
The <info>mesd:setting:cluster:create</info> command creates a setting cluster:

This interactive shell will ask you for a name and description.

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name        = $input->getArgument('name');
        $description = $input->getArgument('description');
        $hiveName    = $input->getArgument('hiveName');

        $settingManager =  $this->getContainer()->get("mesd_settings.setting_manager");

        if ($settingManager->clusterExists($hiveName, $name)) {
            $output->writeln(sprintf('<error>Error: Hive %s and Cluster %s combination already exist</error>', $hiveName, $name));
        }
        else {
            $settingManager->createCluster($name, $description, $hiveName);
            $output->writeln(sprintf('<comment>Created cluster <info>%s</info></comment>', $name));
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
                'Please choose a cluster name:',
                function($name) {
                    if (empty($name)) {
                        throw new \Exception('Cluster name can not be empty');
                    }

                    return $name;
                }
            );
            $input->setArgument('name', $name);
        }

        if (!$input->getArgument('description')) {
            $description = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please enter a description (optional):',
                function($description) {
                    if (empty($description)) {
                        return null;
                    }
                    return $description;
                }
            );
            $input->setArgument('description', $description);
        }

        if (!$input->getArgument('hiveName')) {
            $hiveName = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please enter a hiveName:',
                function($hiveName) {
                    if (empty($hiveName)) {
                        throw new \Exception('Hive name can not be empty');
                    }
                    $settingManager =  $this->getContainer()->get("mesd_settings.setting_manager");
                    if (!$settingManager->hiveExists($hiveName)) {
                        throw new \Exception(sprintf('Hive %s does not exist', $hiveName));
                    }
                    return $hiveName;
                }
            );
            $input->setArgument('hiveName', $hiveName);
        }

    }
}