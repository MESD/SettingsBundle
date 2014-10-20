<?php

namespace Mesd\SettingsBundle\Model\Definition;

use Mesd\SettingsBundle\Model\Definition\SettingNode;

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
     * @param Mesd\SettingsBundle\Model\Definition\SettingNode $settingNode
     * @return SettingDefinition
     */
    public function addSettingNode(SettingNode $settingNode)
    {
        $this->settingNode[$settingNode->getName()] = $settingNode;

        return $this;
    }


    /**
     * Get SettingNode
     *
     * @param string $name
     * @return Mesd\SettingsBundle\Model\Definition\SettingNode $settingNode
     */
    public function getSettingNode($name)
    {
        if ($this->settingNode->containsKey($name)) {
            return $this->settingNode->get($name);
        }
        else {
            return false;
        }
    }


    /**
     * Get SettingNodes
     *
     * @return Doctrine\Common\Collections\ArrayCollection()
     */
    public function getSettingNodes()
    {
        return $this->settingNode;
    }


    /**
     * Remove SettingNode
     *
     * @param Mesd\SettingsBundle\Model\Definition\SettingNode $settingNode
     * @return SettingDefinition
     */
    public function removeSettingNode(SettingNode $settingNode)
    {
        $this->settingNode->removeElement($settingNode);

        return $this;
    }


    /**
     * Remove SettingNode by name
     *
     * @param string $name
     * @return SettingDefinition
     */
    public function removeSettingNodeByName($name)
    {
        $settingNode = $this->getSettingNode($name);

        if ($settingNode) {
            $this->settingNode->removeElement($settingNode);
        }

        return $this;
    }

}