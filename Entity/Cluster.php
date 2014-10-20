<?php

namespace Mesd\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mesd\SettingsBundle\Model\Setting;

/**
 * Cluster
 */
class Cluster
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var array
     */
    private $setting;

    /**
     * @var \Mesd\SettingsBundle\Entity\Hive
     */
    private $hive;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Cluster
     */
    public function setName($name)
    {
        $this->name = strtoupper($name);

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Cluster
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }


    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Add Setting
     *
     * @param Mesd\SettingsBundle\Model\Setting $setting
     * @return Cluster
     */
    public function addSetting(Setting $setting)
    {
        $this->setting[$setting->getName()] = $setting->getValue();

        return $this;
    }


    /**
     * Get setting Array
     *
     * @return array
     */
    public function getSettingArray()
    {
        return $this->setting;
    }


    /**
     * Get setting
     *
     * @param  string settingName
     * @return Mesd\SettingsBundle\Model\Setting $setting
     */
    public function getSetting($settingName)
    {
        $this->setting = is_array($this->setting) ? $this->setting : array();

        if (array_key_exists($settingName, $this->setting)) {
            $setting = new Setting();
            $setting->setName($settingName);
            $setting->setValue($this->setting[$settingName]);

            return $setting;
        }

        return false;
    }


    /**
     * Remove Setting
     *
     * @param Mesd\SettingsBundle\Model\Setting $setting
     * @return Cluster
     */
    public function removeSetting(Setting $setting)
    {
        unset($this->setting[$setting->getName()]);

        return $this;
    }


    /**
     * Set hive
     *
     * @param \Mesd\SettingsBundle\Entity\Hive $hive
     * @return Cluster
     */
    public function setHive(\Mesd\SettingsBundle\Entity\Hive $hive = null)
    {
        $this->hive = $hive;

        return $this;
    }


    /**
     * Get hive
     *
     * @return \Mesd\SettingsBundle\Entity\Hive
     */
    public function getHive()
    {
        return $this->hive;
    }
}