<?php

namespace Fc\SettingsBundle\Model;

use Fc\SettingsBundle\Entity\Hive;
use Fc\SettingsBundle\Entity\Cluster;

class SettingManager {

    private $objectManager;


    public function __construct($objectManager)
    {
         $this->objectManager = $objectManager->getEntityManager();
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
}