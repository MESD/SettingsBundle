<?php

namespace Mesd\SettingsBundle\Model;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Mesd\SettingsBundle\Entity\Hive;
use Mesd\SettingsBundle\Entity\Cluster;
use Mesd\SettingsBundle\Model\Definition\DefinitionManager;
use Mesd\SettingsBundle\Model\SettingValidator;

class SettingManager {

    private $container;


    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    /**
     * Check if cluster exisits
     *
     * Determines if the specified cluster exisits
     * in the database.
     *
     * @param string $hiveName
     * @param string $clusterName
     * @return Cluster|false
     */
    public function clusterExists($hiveName, $clusterName)
    {
        $hive = $this->hiveExists($hiveName);

        if(!$hive) {
            return false;
        }

        $cluster =
            $this->container->get('doctrine.orm.entity_manager')
                ->getRepository('FcSettingsBundle:Cluster')
                ->findOneBy(array(
                    'name' => strtoupper($clusterName),
                    'hive' => $hive
                    )
                );

        return $cluster;
    }


    /**
     * Create a cluster
     *
     * Creates a new cluster in database
     *
     * @param string $clusterName
     * @param string $description
     * @param string $hiveName
     * @return Cluster
     */
    public function createCluster($clusterName, $description = null, $hiveName)
    {
        $hive = $this->hiveExists($hiveName);

        if(!$hive) {
            throw new \Exception(sprintf('Hive %s does not exist', $hiveName));
        }

        $cluster = $this->clusterExists($hiveName, $clusterName);

        if($cluster) {
            throw new \Exception(sprintf('Hive %s and Cluster %s combination already exist', $hiveName, $clusterName));
        }

        $cluster = new Cluster();
        $cluster->setName($clusterName);
        $cluster->setDescription($description);
        $cluster->setHive($hive);
        $this->container->get('doctrine.orm.entity_manager')->persist($cluster);
        $this->container->get('doctrine.orm.entity_manager')->flush();

        return $cluster;
    }


    /**
     * Create a hive
     *
     * Creates a new hive in database
     *
     * @param string $hiveName
     * @param string $description
     * @param bool   $definedAtHive
     * @return Hive
     */
    public function createHive($hiveName, $description = null, $definedAtHive = false)
    {
        $hive = $this->hiveExists($hiveName);

        if($hive) {
            throw new \Exception(sprintf('Hive %s already exists', $hiveName));
        }

        $hive = new Hive();
        $hive->setName($hiveName);
        $hive->setDescription($description);
        $hive->setDefinedAtHive($definedAtHive);
        $this->container->get('doctrine.orm.entity_manager')->persist($hive);
        $this->container->get('doctrine.orm.entity_manager')->flush();

        return $hive;
    }


    /**
     * Check if hive exisits
     *
     * Determines if the specified hive exisits
     * in the database.
     *
     * @param string $hiveName
     * @return Hive|false
     */
    public function hiveExists($hiveName)
    {
        $hive = $this->container->get('doctrine.orm.entity_manager')
            ->getRepository('FcSettingsBundle:Hive')
            ->findOneBy(array('name' => strtoupper($hiveName)));

        return $hive;
    }


    /**
     * Check if hive has clusters
     *
     * Determines if the specified hive has clusters
     * exisiting in the database.
     *
     * @param string $hiveName
     * @return Hive|false
     */
    public function hiveHasClusters($hiveName)
    {
        $hive = $this->container->get('doctrine.orm.entity_manager')
            ->getRepository('FcSettingsBundle:Hive')
            ->findOneBy(array('name' => strtoupper($hiveName)));

        if (0 < $hive->getCluster()->count()) {
            return $hive;
        }

        return false;
    }


    /**
     * Load cluster
     *
     * Load the specified cluster or throw Exception.
     *
     * @param string $hiveName
     * @param string $clusterName
     * @return Cluster|Exception
     */
    public function loadCluster($hiveName, $clusterName)
    {
        $cluster = $this->clusterExists($hiveName, $clusterName);

        if (!$cluster) {
            throw new \Exception(sprintf('The hive %s and Cluster %s combination do not exist', $hiveName, $clusterName));
        }

        return $cluster;
    }


    /**
     * Load hive
     *
     * Load the specified hive or throw Exception.
     *
     * @param string $hiveName
     * @return Hive|Exception
     */
    public function loadHive($hiveName)
    {
        $hive = $this->hiveExists($hiveName);

        if (!$hive) {
            throw new \Exception(sprintf('The hive %s does not exist', $hiveName));
        }

        return $hive;
    }


    /**
     * Load setting
     *
     * Load the specified setting or throw Exception.
     *
     * Optionaly, load the SettingNode definition and set it within the
     * setting object. This operation requires extra resources and time,
     * and therefore should only be done when the SettingNode definition
     * is needed.
     *
     * @param string $hiveName
     * @param string $clusterName
     * @param string $settingName
     * @param boolean $loadDefinition (optional)
     * @return Setting|Exception
     */
    public function loadSetting($hiveName, $clusterName, $settingName, $loadDefinition = false)
    {
        $cluster = $this->loadCluster($hiveName, $clusterName);

        $setting = $cluster->getSetting($settingName);

        if (!$setting) {
            throw new \Exception(sprintf(
                "Setting '%s' does not exist in the Hive '%s' and Cluster '%s' combination",
                $settingName,
                $hiveName,
                $clusterName
            ));
        }

        if (true === $loadDefinition) {
            $settingDefinition = $this->container->get('mesd_settings.definition_manager')->loadFile($hiveName, $clusterName);

            $setting->setNodeDefinition(
                $settingDefinition->getSettingNode($settingName)
            );
        }

        return $setting;
    }



    /**
     * Save setting
     *
     * Save the specified setting or throw Exception.
     *
     * @param string $hiveName
     * @param string $clusterName
     * @param string $settingName
     * @param mixed $settingValue
     * @return Setting|Exception
     */
    public function saveSetting($hiveName, $clusterName, $settingName, $settingValue)
    {
        $cluster = $this->loadCluster($hiveName, $clusterName);

        $setting = $cluster->getSetting($settingName);

        if (!$setting) {
            throw new \Exception(sprintf(
                "Setting '%s' does not exist in the Hive '%s' and Cluster '%s' combination",
                $settingName,
                $hiveName,
                $clusterName
            ));
        }

        $settingDefinition = $this->container->get('mesd_settings.definition_manager')->loadFile($hiveName, $clusterName);

        $setting->setValue($settingValue);


        $settingValidator = new SettingValidator(
            $settingDefinition->getSettingNode($settingName),
            $setting
        );

        $validationResults = $settingValidator->validate();

        if (!$validationResults['valid']) {
            throw new \Exception(sprintf(
                "Hive '%s' - Cluster '%s' have invalid setting '%s': \n %s",
                $hiveName,
                $clusterName,
                $setting->getName(),
                $validationResults['validationMessage']
            ));
        }

        $cluster->addSetting($setting);

        $this->container->get('doctrine.orm.entity_manager')->persist($cluster);
        $this->container->get('doctrine.orm.entity_manager')->flush();

        return $setting;
    }

}