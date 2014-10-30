<?php

/**
 * This file is part of the MesdSettingsBundle.
 *
 * (c) MESD <appdev@mesd.k12.or.us>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Mesd\SettingsBundle\Model\Definition;

use Doctrine\Common\Collections\ArrayCollection;
use Mesd\SettingsBundle\Model\Definition\SettingNode;

/**
 * Setting Definition once unserialized from yaml file.
 *
 * @author David Cramblett <dcramble@mesd.k12.or.us>
 */
class SettingDefinition
{

    /**
     * Setting definition key
     *
     * @var string
     */
    private $key;

    /**
     * Setting definition hive name
     *
     * @var string
     */
    private $hiveName;

    /**
     * Setting definition type
     *
     * @var string
     */
    private $type;

    /**
     * Setting definition file path
     *
     * @var string
     */
    private $filePath;

    /**
     * Setting definition node collection
     *
     * @var ArrayCollection
     */
    private $settingNode;


    /**
     * Constructor
     *
     * @return self
     */
    public function __construct()
    {
        $this->settingNode = new ArrayCollection();
    }

    /**
     * Get setting definition key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set setting definition key
     *
     * @param  string $key
     * @return self
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get setting definition hive name
     *
     * @return string
     */
    public function getHiveName()
    {
        return $this->hiveName;
    }

    /**
     * Set setting definition hive name
     *
     * @param  string $hiveName
     * @return self
     */
    public function setHiveName($hiveName)
    {
        $this->hiveName = $hiveName;

        return $this;
    }

    /**
     * Get setting definition type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set setting definition type
     *
     * @param  string $type
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get setting definition file path
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Set setting definition file path
     *
     * @param  string $filePath
     * @return self
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * Add SettingNode
     *
     * @param SettingNode $settingNode
     * @return self
     */
    public function addSettingNode(SettingNode $settingNode)
    {
        $this->settingNode[$settingNode->getName()] = $settingNode;

        return $this;
    }

    /**
     * Get SettingNode by node name
     *
     * @param string $name
     * @return SettingNode
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
     * Get all setting nodes
     *
     * @return ArrayCollection
     */
    public function getSettingNodes()
    {
        return $this->settingNode;
    }

    /**
     * Remove setting node
     *
     * @param SettingNode $settingNode
     * @return self
     */
    public function removeSettingNode(SettingNode $settingNode)
    {
        $this->settingNode->removeElement($settingNode);

        return $this;
    }

    /**
     * Remove setting node by node name
     *
     * @param string $name
     * @return self
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