<?php

namespace Fc\SettingsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\DialogHelper;
use Fc\SettingsBundle\Entity\Cluster;
use Fc\SettingsBundle\Model\Definition\SettingDefinition;
use Fc\SettingsBundle\Model\Setting;


class ValidateSettingsCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('fc:setting:setting:validate')
            ->setDescription('Validate settings.')
            ->setDefinition(array(
                new InputOption('forceInsert', null, InputOption::VALUE_NONE, 'Force the insert of new settings - no user prompt'),
                new InputOption('forceUpdate', null, InputOption::VALUE_NONE, 'Force the update of existing settings - no user prompt'),
                new InputOption('forceDelete', null, InputOption::VALUE_NONE, 'Force the delete of existing settings - no user prompt'),
                new InputOption('forceAll',    null, InputOption::VALUE_NONE, 'Force insert, update, and delete of settings - no user prompt'),
              ))
            ->setHelp(<<<EOT
The <info>fc:setting:setting:validate</info> command validates all settings
in the database, in relation to the setting definition(s).

The validate process will prompt the user for confirmation on any required
changes to settings in the database.

There are three types of changes that could be required:

  Insert - New settings that have been defined, but don't exisit in database.
           Inserts should not be destructive to exisitng data.

  Update - Changes to the setting definition that need to be applied to
           settings in the database. Updates can potentially be destructive
           to exisitng data. i.e. Format change where value is no longer
           compatable.

  Delete - Removed nodes from setting definition that need to be purged from
           the settings in the database. Deletes are always destructive to
           exisitng data.

Force inserts without prompting for confirmation with the <comment>--forceInsert</comment> option:

<info>php app/console fc:setting:setting:validate --forceInsert</info>

Force updates without prompting for confirmation with the <comment>--forceUpdate</comment> option:

<info>php app/console fc:setting:setting:validate --forceUpdate</info>

Force deletes without prompting for confirmation with the <comment>--forceDelete</comment> option:

<info>php app/console fc:setting:setting:validate --forceDelete</info>

Force all modifications without prompting for confirmation with the <comment>--forceAll</comment> option:

<info>php app/console fc:setting:setting:validate --forceAll</info>

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get user options
        $confirmation = array(
            'forceInsert' => $input->getOption('forceInsert'),
            'forceUpdate' => $input->getOption('forceUpdate'),
            'forceDelete' => $input->getOption('forceDelete'),
            'forceAll'    => $input->getOption('forceAll')
        );

        // Get needed services
        $settingManager    = $this->getContainer()->get("fc_settings.setting_manager");
        $definitionManager = $this->getContainer()->get("fc_settings.definition_manager");
        $entityManager     = $this->getContainer()->get("doctrine.orm.entity_manager");

        // Get Dialog Helper
        $dialog = $this->getHelper('dialog');

        // Load hive collection
        $hiveCollection = $entityManager
            ->getRepository('FcSettingsBundle:Hive')
            ->findAll();

        // Loop through all hives validating as we go
        foreach ($hiveCollection as $hiveKey => $hive) {

            // If settings are defined at hive, clusters
            // will use the same SettingDefinition.
            if ($hive->getDefinedAtHive()) {

                $output->writeln(array(
                    '',
                    sprintf(
                        '<comment>Hive: %s - Settings defined at hive</comment>',
                        $hive->getName()
                    ),
                    ''
                ));

                // Load hive's SettingDefinition
                $settingDefinition = $definitionManager
                    ->loadFile(strtolower($hive->getName())
                );

                // Load Hive's cluster collection
                $clusterCollection = $hive->getCluster();

                // Loop through clusters
                foreach ($clusterCollection as $clusterKey => $cluster) {
                    $cluster = $this->validateCluster($cluster, $settingDefinition, $input, $output, $dialog, $confirmation);
                }

            }

            // Settings are defined at cluster, each using
            // their own SettingDefinition.
            else {

                $output->writeln(array(
                    '',
                    sprintf(
                        '<comment>Hive: %s - Settings defined at cluster</comment>',
                        $hive->getName()
                    ),
                    ''
                ));

            }

        }


        $output->writeln(array(
            '',
            '<info>Setting validation complete!</info>',
            ''
        ));
    }


    /**
     * Validate a cluster against a setting definition
     *
     * @param Cluster
     * @param SettingDefinition
     * @param InputInterface
     * @param OutputInterface
     * @param DialogHelper
     * @param array $confirmation
     * @return Cluster
     */
    protected function validateCluster($cluster, $settingDefinition, $input, $output, $dialog, $confirmation)
    {

        $clusterExisitngSettings = $cluster->getSettingArray();
        print_r($cluster->getSettingArray());

        if(!is_array($clusterExisitngSettings)) {
            $clusterExisitngSettings = array();
        }

        // First check each setting node in definition
        // and determine exisitance/compliance in cluster
        foreach ($settingDefinition->getSettingNodes() as $settingKey => $setting ) {

            // Check for existance;
            if(!array_key_exists($settingKey, $clusterExisitngSettings)) {
                $newSetting = new Setting();
                $newSetting->setName($settingKey);
                $newSetting->setValue($setting->getDefault());
                $cluster->addSetting($newSetting);
            }

        }

        print_r($cluster->getSettingArray());

        //var_dump($cluster->getSettingArray());
        //print_r($settingDefinition->getSettingNodes());
        exit;

    }

}