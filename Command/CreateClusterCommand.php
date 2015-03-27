<?php

namespace Mesd\SettingsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
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
                new InputArgument('hiveName', InputArgument::REQUIRED, 'Hive name to attach Cluster'),
                new InputArgument('clusterName', InputArgument::REQUIRED, 'Cluster Name'),
                new InputArgument('description', InputArgument::OPTIONAL, 'Cluster Description'),
                new InputOption('noDefine', null, InputOption::VALUE_NONE, 'Do not ask to define settings'),
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
        $hiveName    = $input->getArgument('hiveName');
        $clusterName = $input->getArgument('clusterName');
        $description = $input->getArgument('description');
        $noDefine    = $input->getOption('noDefine');

        $settingManager =  $this->getContainer()->get("mesd_settings.setting_manager");

        $settingManager->createCluster($hiveName, $clusterName, $description);
        $output->writeln(sprintf('<comment>Created cluster <info>%s</info></comment>', $clusterName));

        // If user did not request to ignore setting definition at command line,
        // offer to define cluster settings now.
        if (!$noDefine) {
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
                    'command'     => 'mesd:setting:setting:define',
                    'hiveName'    => $hiveName,
                    'clusterName' => $clusterName,
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

        if (!$input->getArgument('clusterName')) {
            $clusterName = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a cluster name:',
                function($clusterName) use (&$hiveName) {
                    if (empty($clusterName)) {
                        throw new \Exception('Cluster name can not be empty');
                    }
                    $settingManager =  $this->getContainer()->get("mesd_settings.setting_manager");
                    if ($settingManager->clusterExists($hiveName, $clusterName)) {
                        throw new \Exception(sprintf(
                            'Hive %s and Cluster %s combination already exist',
                            $hiveName,
                            $clusterName
                        ));
                    }

                    return $clusterName;
                }
            );
            $input->setArgument('clusterName', $clusterName);
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
    }
}
