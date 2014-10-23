<?php

namespace Mesd\SettingsBundle\Model;

use Mesd\SettingsBundle\Entity\Cluster;
use Mesd\SettingsBundle\Model\Definition\SettingNode;

class Setting {

    private $name;
    private $value;
    private $nodeDefinition;
    private $cluster;


    /**
     * Is SettingNode definition loaded
     *
     * Determine if the SettingNode definition has been loaded.
     *
     * The SettingManager loadSetting() method has an optional
     * fourth parameter which can be set to true if you would like
     * the SettingNode definition to be loaded when the setting is
     * retrieved. This requires loading, parsing, and validating
     * the SettingDefinition Yaml file, which will take a little
     * extra time. Since the SettingNode definition data is not
     * commonly needed when retrieving settings and their values,
     * the default behavior is to not loaded the SettingNode
     * definition.
     *
     * @return boolean true|false
     */
    public function isNodeDefinitionLoaded()
    {
        if ($this->nodeDefinition instanceof SettingNode) {
            return true;
        }
        else {
            return false;
        }
    }


    public function getName()
    {
        return $this->name;
    }


    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    public function getValue()
    {
        return $this->value;
    }


    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }


    /**
     * Get cluster
     *
     * @return Mesd\SettingsBundle\Entity\Cluster
     */
    public function getCluster()
    {
        return $this->cluster;
    }


    /**
     * Set cluster
     *
     * @param Mesd\SettingsBundle\Entity\Cluster $cluster
     */
    public function setCluster(Cluster $cluster)
    {
        $this->cluster = $cluster;

        return $this;
    }


    /**
     * Get SettingNode definition
     *
     * Get the SettingNode definition, if it has been
     * loaded. See isNodeDefinitionLoaded() below for
     * more details.
     *
     * @return SettingNode|null
     */
    public function getNodeDefinition()
    {
        if (!$this->isNodeDefinitionLoaded()) {
            throw new \Exception(
                'The SettingNode definition has not been loaded. Please see the documentation ' .
                'for the SettingManager loadSetting() method.'
            );
        }

        return $this->nodeDefinition;
    }


    /**
     * Set SettingNode definition
     *
     * Set the setting node definition.
     *
     * @param Mesd\SettingsBundle\Model\Setting $setting
     * @return SettingNode
     */
    public function setNodeDefinition(SettingNode $settingNode)
    {
        $this->nodeDefinition = $settingNode;

        return $this;
    }
}