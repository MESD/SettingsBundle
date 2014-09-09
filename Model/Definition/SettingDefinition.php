<?php

namespace Fc\SettingsBundle\Model\Definition;

use Fc\SettingsBundle\Model\Definition\SettingNode;

class SettingDefinition
{

    private $key;
    private $hive;
    private $type;
    private $settingDefinition;


    public function __construct(array $fileContents = null)
    {
        $this->settingDefinition = new \Doctrine\Common\Collections\ArrayCollection();

        if (null !== $fileContents) {
            $this->unserialize($fileContents);
        }
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
     * Add SettingDefinition
     *
     * @param Fc\SettingsBundle\Model\Definition\SettingDefinition $settingDefinition
     * @return Cluster
     */
    public function addSettingDefinition(SettingDefinition $settingDefinition)
    {
        $this->settingDefinition[] = $settingDefinition;

        return $this;
    }


    /**
     * Get SettingDefinition Array
     *
     * @return array
     */
    public function getSettingDefinitionArray()
    {
        return $this->settingDefinition;
    }


    /**
     * Get SettingDefinition
     *
     * @param  string settingDefinitionName
     * @return Fc\SettingsBundle\Model\Definition\SettingDefinition
     */
    public function getSettingDefinition($settingDefinitionName)
    {
        if ($this->setting[$settingDefinitionName]) {
            $SettingDefinition = new SettingDefinition();
            $SettingDefinition->setName($settingName);
            $SettingDefinition->setValue($this->setting[$settingName]);

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