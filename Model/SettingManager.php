<?php

/**
 * This file is part of the MesdSettingsBundle.
 *
 * (c) MESD <appdev@mesd.k12.or.us>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Mesd\SettingsBundle\Model;

use Doctrine\Common\Persistence\ObjectManager;
use Mesd\SettingsBundle\Entity\Hive;
use Mesd\SettingsBundle\Entity\Cluster;
use Mesd\SettingsBundle\Model\Definition\DefinitionManager;
use Mesd\SettingsBundle\Model\Setting;
use Mesd\SettingsBundle\Model\SettingValidator;

/**
 * Service for managing settings.
 *
 * @author David Cramblett <dcramble@mesd.k12.or.us>
 */
class SettingManager {

    /**
     * Doctrine entity manager
     *
     * @var ObjectManager
     */
     private $objectManager;

     /**
     * Setting definition manager service
     *
     * @var DefinitionManager
     */
     private $definitionManager;


    /**
     * Constructor
     *
     * @param ObjectManager $objectManager
     * @param DefinitionManager $definitionManager
     * @return self
     */
    public function __construct(ObjectManager $objectManager, DefinitionManager $definitionManager)
    {
        $this->objectManager     = $objectManager;
        $this->definitionManager = $definitionManager;
    }


    /**
     * Check if cluster exists
     *
     * Determines if the specified cluster exists
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
                ->getRepository('MesdSettingsBundle:Cluster')
                ->findOneBy(array(
                    'name' => strtoupper($clusterName),
                    'hive' => $hive
                    )
                );
                
        if (is_null($cluster)) {
            return false;
        }

        return $cluster;
    }


    /**
     * Creates a new cluster in database
     *
     * @param string $hiveName
     * @param string $clusterName
     * @param string $description
     * @return Cluster
     */
    public function createCluster($hiveName, $clusterName, $description = null)
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
        $hive->addCluster($cluster);

        // Populate settings from SettingDefinition
        try {
            $settingDefinition = $this->definitionManager
                ->loadFileByHiveAndCluster($hive, $cluster);
            }
        catch (\Exception $e){
            $settingDefinition = false;
        }

        if ($settingDefinition) {
            foreach ($settingDefinition->getSettingNodes() as $key => $node) {
                $setting = new Setting();
                $setting->setName($node->getName());
                $setting->setValue($node->getDefault());
                $cluster->addSetting($setting);
            }
        }

        $this->objectManager->persist($cluster);
        $this->objectManager->flush();

        return $cluster;
    }


    /**
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
     * Delete the specified cluster or throw Exception.
     *
     * @param string $hiveName
     * @param string $clusterName
     * @return true|Exception
     */
    public function deleteCluster($hiveName, $clusterName)
    {
        $cluster = $this->clusterExists($hiveName, $clusterName);

        if (!$cluster) {
            throw new \Exception(sprintf('The hive %s and Cluster %s combination does not exist', $hiveName, $clusterName));
        }

        $this->objectManager->remove($cluster);
        $this->objectManager->flush();

        return true;
    }


    /**
     * Delete the specified hive or throw Exception.
     *
     * @param string $hiveName
     * @return true|Exception
     */
    public function deleteHive($hiveName)
    {
        $hive = $this->hiveHasClusters($hiveName);

        if ($hive) {
            throw new \Exception(sprintf('The hive %s still has clusters attached', $hiveName));
        }

        $hive = $this->loadHive($hiveName);

        $this->objectManager->remove($hive);
        $this->objectManager->flush();

        return true;
    }


    /**
     * Delete all the clusters attached to specific hive.
     *
     * @param string $hiveName
     * @return true|false
     */
    public function deleteHiveClusters($hiveName)
    {
        $hive = $this->hiveHasClusters($hiveName);

        if (!$hive) {
            print "No Clusters Found!";
            return false;
        }

        foreach ($hive->getCluster() as $key => $cluster) {
            $this->objectManager->remove($cluster);
        }

        $this->objectManager->flush();

        return true;
    }


    /**
     * Determines if the specified hive exists
     * in the database.
     *
     * @param string $hiveName
     * @return Hive|false
     */
    public function hiveExists($hiveName)
    {
        $hive = $this->objectManager
            ->getRepository('MesdSettingsBundle:Hive')
            ->findOneBy(array('name' => strtoupper($hiveName)));

        if (is_null($hive)) {
            return false;
        }

        return $hive;
    }


    /**
     * Determines if the specified hive has clusters
     * existing in the database.
     *
     * @param string $hiveName
     * @return Hive|false
     */
    public function hiveHasClusters($hiveName)
    {
        $hive = $this->hiveExists($hiveName);

        if (!$hive) {
            throw new \Exception(sprintf('The hive %s does not exist', $hiveName));
        }

        $hive = $this->objectManager
            ->getRepository('MesdSettingsBundle:Hive')
            ->findOneBy(array('name' => strtoupper($hiveName)));

        if (0 < $hive->getCluster()->count()) {
            return $hive;
        }

        return false;
    }


    /**
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
     * Load the specified setting object or throw Exception.
     *
     * Optionaly, load the SettingNode definition and set it within the
     * setting object. This operation requires extra resources and time,
     * and therefore should only be done when the SettingNode definition
     * is needed.
     *
     * @param string $hiveName
     * @param string $clusterName
     * @param string $settingName
     * @param boolean $loadDefinition [optional]
     * @return Setting|Exception
     */
    public function loadSetting($hiveName, $clusterName, $settingName, $loadDefinition = false)
    {
        $cluster = $this->loadCluster($hiveName, $clusterName);

        $setting = $cluster->getSetting($settingName);

        if (!$setting) {
            throw new \Exception(sprintf(
                "Load Setting Failed: Setting '%s' does not exist in the Hive '%s' and Cluster '%s' combination",
                $settingName,
                $hiveName,
                $clusterName
            ));
        }

        if (true === $loadDefinition) {
            $settingDefinition = $this->definitionManager
                ->loadFileByHiveAndCluster(
                    $cluster->getHive(),
                    $cluster
                );

            $setting->setSettingNode(
                $settingDefinition->getSettingNode($settingName)
            );
        }

        return $setting;
    }


    /**
     * Load the specified setting value or throw Exception.
     *
     * @param string $hiveName
     * @param string $clusterName
     * @param string $settingName
     * @return string|Exception
     */
    public function loadSettingValue($hiveName, $clusterName, $settingName)
    {
        $cluster = $this->loadCluster($hiveName, $clusterName);

        $setting = $cluster->getSetting($settingName);

        if (!$setting) {
            throw new \Exception(sprintf(
                "Load Setting Value Failed: Setting '%s' does not exist in the Hive '%s' and Cluster '%s' combination",
                $settingName,
                $hiveName,
                $clusterName
            ));
        }

        return $setting->getValue();
    }


    /**
     * Save the specified setting object or throw Exception.
     *
     * @param mixed $setting
     * @return Setting|Exception
     */
    public function saveSetting(Setting $setting)
    {
        $settingDefinition = $this->definitionManager
            ->loadFileByHiveAndCluster(
                $setting->getCluster()->getHive(),
                $setting->getCluster()
            );

        $settingValidator = new SettingValidator(
            $settingDefinition->getSettingNode($setting->getName()),
            $setting
        );

        $validationResults = $settingValidator->validate();

        if (!$validationResults['valid']) {
            throw new \Exception(sprintf(
                "Hive '%s' - Cluster '%s' have invalid setting '%s': \n %s",
                $setting->getCluster()->getHive()->getName(),
                $setting->getCluster()->getName(),
                $setting->getName(),
                $validationResults['validationMessage']
            ));
        }

        $cluster = $setting->getCluster();

        $cluster->addSetting($setting);

        $this->objectManager->persist($cluster);
        $this->objectManager->flush();

        return $setting;
    }


    /**
     * Save the specified setting value or throw Exception.
     *
     * @param string $hiveName
     * @param string $clusterName
     * @param string $settingName
     * @param mixed  $settingValue
     * @return Setting|Exception
     */
    public function saveSettingValue($hiveName, $clusterName, $settingName, $settingValue)
    {
        $cluster = $this->loadCluster($hiveName, $clusterName);

        $setting = $cluster->getSetting($settingName);

        if (!$setting) {
            throw new \Exception(sprintf(
                "Save Setting Value Failed: Setting '%s' does not exist in the Hive '%s' and Cluster '%s' combination",
                $settingName,
                $hiveName,
                $clusterName
            ));
        }

        $settingDefinition = $this->definitionManager
            ->loadFileByHiveAndCluster(
                $cluster->getHive(),
                $cluster
            );

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

        $this->objectManager->persist($cluster);
        $this->objectManager->flush();

        return $setting;
    }

}
