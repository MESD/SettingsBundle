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
        $this->settingDefinition = new \Doctrine\Common\Collections\ArrayCollection();
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
    public function addSettingNode(SettingDefinition $settingNode)
    {
        $this->settingNode[] = $settingNode;

        return $this;
    }


    /**
     * Get SettingNode Array
     *
     * @return array
     */
    public function getSettingNodeArray()
    {
        return $this->SettingNode;
    }


    /**
     * Get SettingNode
     *
     * @param  string settingNodeName
     * @return Fc\SettingsBundle\Model\Definition\SettingNode
     */
    public function getSettingNode($settingNodeName)
    {
        if ($this->setting[$settingNodeName]) {
            $ettingNode = new SettingDefinition();
            $settingNode->setName($settingName);
            $settingNode->setValue($this->setting[$settingName]);

            return $setting;
        }

        return false;
    }


    /**
     * Remove Setting
     *
     * @param Fc\SettingsBundle\Model\Setting $setting
     * @return Cluster
     */
    public function removeSetting(SettingDefinition $setting)
    {
        unset($this->setting[$setting->getName()]);

        return $this;
    }

}