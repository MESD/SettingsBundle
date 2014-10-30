<?php

/**
 * This file is part of the MesdSettingsBundle.
 *
 * (c) MESD <appdev@mesd.k12.or.us>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Mesd\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mesd\SettingsBundle\Entity\Hive;
use Mesd\SettingsBundle\Model\Setting;

/**
 * Cluster databse entity.
 *
 * @author David Cramblett <dcramble@mesd.k12.or.us>
 */
class Cluster
{
    /**
     * Cluster ID
     *
     * @var integer
     */
    private $id;

    /**
     * Cluster name
     *
     * @var string
     */
    private $name;

    /**
     * Cluster description
     *
     * @var string
     */
    private $description;

    /**
     * Cluster settings
     *
     * @var array
     */
    private $setting;

    /**
     * Hive parent to cluster
     *
     * @var Hive
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
     * @param Setting $setting
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
     * @param  string $settingName
     * @return Setting
     */
    public function getSetting($settingName)
    {
        $this->setting = is_array($this->setting) ? $this->setting : array();

        if (array_key_exists($settingName, $this->setting)) {
            $setting = new Setting();
            $setting->setName($settingName);
            $setting->setValue($this->setting[$settingName]);
            $setting->setCluster($this);

            return $setting;
        }

        return false;
    }


    /**
     * Remove Setting
     *
     * @param Setting $setting
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
     * @param Hive $hive
     * @return Cluster
     */
    public function setHive(Hive $hive = null)
    {
        $this->hive = $hive;

        return $this;
    }


    /**
     * Get hive
     *
     * @return Hive
     */
    public function getHive()
    {
        return $this->hive;
    }
}