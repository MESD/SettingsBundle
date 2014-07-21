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


    public function createHive($name, $description, $definedAtHive = false)
    {
        $hive = new Hive();
        $hive->setName($name);
        $hive->setDescription($description);
        $hive->setDefinedAtHive($definedAtHive);
        $this->objectManager->persist($hive);
        $this->objectManager->flush();
    }


}