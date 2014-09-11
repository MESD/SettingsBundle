<?php

namespace Fc\SettingsBundle\Model\Definition;

use Fc\SettingsBundle\Model\Definition\SettingNode;

class SettingDefinition
{

    private $key;
    private $hive;
    private $type;
    private $settingNode;


    public function __construct()
    {
        $this->settingNode = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function getKey()
    {
        return $this->key;
    }


    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }


    public function getHive()
    {
        return $this->hive;
    }


    public function setHive($hive)
    {
        $this->hive = $hive;

        return $this;
    }


    public function getType()
    {
        return $this->type;
    }


    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }


    /**
     * Add SettingNode
     *
     * @param Fc\SettingsBundle\Model\Definition\SettingNode $settingNode
     * @return Cluster
     */
    public function addSettingNode(SettingNode $settingNode)
    {
        $this->settingNode[] = $settingNode;

        return $this;
    }


    /**
     * Get SettingNode
     *
     * @return Doctrine\Common\Collections\ArrayCollection()
     */
    public function getSettingNode()
    {
        return $this->settingNode;
    }


    /**
     * Remove SettingNode
     *
     * @param Fc\SettingsBundle\Model\Definition\SettingNode $settingNode
     * @return Cluster
     */
    public function removeSettingNode(SettingDefinition $settingNode)
    {
        $this->settingNode->removeElement($settingNode);

        return $this;
    }

}