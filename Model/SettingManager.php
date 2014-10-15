<?php

namespace Fc\SettingsBundle\Model;

use Fc\SettingsBundle\Entity\Hive;
use Fc\SettingsBundle\Entity\Cluster;
use Fc\SettingsBundle\Model\Definition\DefinitionManager;

class SettingManager {

    private $definitionManager;
    private $objectManager;

    public function __construct($objectManager)
    {
         $this->objectManager = $objectManager->getEntityManager();
    }


    /**
     * Set Definition Manager Service
     *
     * Setter Injection for the DefinitionManager service.
     * Would prefer to use constructor injection, but since
     * the DefinitionManager also uses the SettingManager
     * circular references would be created.
     *
     * @param DefinitionManager
     */
    public function setDefinitionManager(DefinitionManager $definitionManager)
    {
        $this->definitionManager = $definitionManager;
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
            $this->objectManager
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
        $this->objectManager->persist($cluster);
        $this->objectManager->flush();

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
        $this->objectManager->persist($hive);
        $this->objectManager->flush();

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
        $hive = $this->objectManager
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
        $hive = $this->objectManager
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
     * Load setting
     *
     * Load the specified setting or throw Exception.
     *
     * @param string $hiveName
     * @param string $clusterName
     * @param string $settingName
     * @return Setting|Exception
     */
    public function loadSetting($hiveName, $clusterName, $settingName, $loadDefinition = false)
    {
        $cluster = $this->clusterExists($hiveName, $clusterName);

        if (!$cluster) {
            throw new \Exception(sprintf('The hive %s and Cluster %s combination do not exist', $hiveName, $clusterName));
        }

        $setting = $cluster->getSetting($settingName);

        if (!$setting) {
            throw new \Exception(sprintf(
                'Setting %s does not exist in the Hive %s and Cluster %s combination',
                $settingName,
                $hiveName,
                $clusterName
            ));
        }

        $this->definitionManager->loadFile($hiveName, $clusterName);

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
     * @return Setting|Exception
     */
    public function saveSetting($hiveName, $clusterName, $settingName, $settingValue)
    {
        $cluster = $this->clusterExists($hiveName, $clusterName);

        if (!$cluster) {
            throw new \Exception(sprintf('The hive %s and Cluster %s combination do not exist', $hiveName, $clusterName));
        }

        $setting = $cluster->getSetting($settingName);

        if (!$setting) {
            throw new \Exception(sprintf(
                'Setting %s does not exist in the Hive %s and Cluster %s combination',
                $settingName,
                $hiveName,
                $clusterName
            ));
        }

        $setting->setValue($settingValue);
        $cluster->addSetting($setting);

        $this->objectManager->persist($cluster);
        $this->objectManager->flush();

        return $setting;
    }

}