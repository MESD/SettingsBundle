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

use Mesd\SettingsBundle\Entity\Cluster;
use Mesd\SettingsBundle\Model\Definition\SettingNode;

/**
 * Setting.
 *
 * @author David Cramblett <dcramble@mesd.k12.or.us>
 */
class Setting {

    /**
     * The setting name
     *
     * @var string
     */
    private $name;

    /**
     * The setting value
     *
     * @var mixed
     */
    private $value;

    /**
     * SettingNode from the SettingDefinition
     *
     * @var Mesd\SettingsBundle\Model\Definition\SettingNode
     */
    private $settingNode;

    /**
     * Cluster Entity
     *
     * @var Mesd\SettingsBundle\Entity\Cluster
     */
    private $cluster;


    /**
     * Is SettingNode loaded
     *
     * Determine if the SettingNode has been loaded.
     *
     * The SettingManager loadSetting() method has an optional fourth parameter
     * which can be set to true if you would like the SettingNode definition to
     * be loaded when the setting is retrieved. This requires loading, parsing,
     * and validating the SettingDefinition Yaml file, which will take a little
     * extra time. Since the SettingNode definition data is not commonly needed
     * when retrieving settings and their values, the default behavior is to
     * not loaded the SettingNode.
     *
     * @return boolean true|false
     */
    public function isSettingNodeLoaded()
    {
        if ($this->settingNode instanceof SettingNode) {
            return true;
        }
        else {
            return false;
        }
    }


    /**
     * Get Setting Name
     *
     * @return string Setting Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Setting Name
     *
     * @param string $name Setting Name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Setting Value
     *
     * @return mixed Setting Value
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * Set Setting Value
     *
     * @param mixed $value Setting Value
     *
     * @return self
     */
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
     *
     * @return self
     */
    public function setCluster(Cluster $cluster)
    {
        $this->cluster = $cluster;

        return $this;
    }


    /**
     * Get SettingNode definition
     *
     * Get the SettingNode definition, if it has been loaded. See
     * isSettingNodeLoaded() for more details.
     *
     * @return SettingNode|Excption
     */
    public function getSettingNode()
    {
        if (!$this->isSettingNodeLoaded()) {
            throw new \Exception(
                'The SettingNode definition has not been loaded. Please see the documentation ' .
                'for the SettingManager loadSetting() method.'
            );
        }

        return $this->settingNode;
    }


    /**
     * Set SettingNode definition
     *
     * @param Mesd\SettingsBundle\Model\Definition\SettingNode $settingNode
     *
     * @return self
     */
    public function setSettingNode(SettingNode $settingNode)
    {
        $this->settingNode = $settingNode;

        return $this;
    }
}