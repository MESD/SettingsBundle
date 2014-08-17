<?php

namespace Fc\SettingsBundle\Model;

use Fc\SettingsBundle\Entity\Hive;
use Fc\SettingsBundle\Entity\Cluster;

class SettingManager {

    private $objectManager;


    public function __construct($objectManager)
    {
         $this->objectManager     = $objectManager->getEntityManager();
    }


    public function createCluster($name, $description = null, $hiveName)
    {
        $hive = $this->hiveExists($hiveName);

        if(!$hive) {
            throw new \Exception(sprintf('Hive %s does not exist', $hiveName));
        }

        $cluster = $this->clusterExists($hiveName, $name);

        if($cluster) {
            throw new \Exception(sprintf('Hive %s and Cluster %s combination already exists', $hiveName, $name));
        }

        $cluster = new Cluster();
        $cluster->setName($name);
        $cluster->setDescription($description);
        $cluster->setHive($hive);
        $this->objectManager->persist($cluster);
        $this->objectManager->flush();

        return $cluster;
    }


    public function createHive($name, $description = null, $definedAtHive = false)
    {
        $hive = $this->hiveExists($name);

        if($hive) {
            throw new \Exception(sprintf('Hive %s already exists', $name));
        }

        $hive = new Hive();
        $hive->setName($name);
        $hive->setDescription($description);
        $hive->setDefinedAtHive($definedAtHive);
        $this->objectManager->persist($hive);
        $this->objectManager->flush();

        return $hive;
    }


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


    public function hiveExists($name)
    {
        $hive = $this->objectManager
                    ->getRepository('FcSettingsBundle:Hive')
                    ->findOneBy(array('name' => strtoupper($name)));

        return $hive;
    }
}