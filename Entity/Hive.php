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
use Doctrine\Common\Collections\Collection;
use Mesd\SettingsBundle\Entity\Cluster;

/**
 * Hive databse entity.
 *
 * @author David Cramblett <dcramble@mesd.k12.or.us>
 */
class Hive
{
    /**
     * Hive ID
     *
     * @var integer
     */
    private $id;

    /**
     * Hive name
     *
     * @var string
     */
    private $name;

    /**
     * Hive description
     *
     * @var string
     */
    private $description;

    /**
     * Settings defined at hive
     *
     * @var boolean
     */
    private $definedAtHive;

    /**
     * Cluster children belonging to hive
     *
     * @var Collection
     */
    private $cluster;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cluster = new ArrayCollection();
    }

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
     * @return Hive
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
     * @return Hive
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
     * Set definedAtHive
     *
     * @param boolean $definedAtHive
     * @return Hive
     */
    public function setDefinedAtHive($definedAtHive)
    {
        $this->definedAtHive = $definedAtHive;

        return $this;
    }

    /**
     * Get definedAtHive
     *
     * @return boolean
     */
    public function getDefinedAtHive()
    {
        return $this->definedAtHive;
    }

    /**
     * Add cluster
     *
     * @param Cluster $cluster
     * @return Hive
     */
    public function addCluster(Cluster $cluster)
    {
        $this->cluster[] = $cluster;

        return $this;
    }

    /**
     * Remove cluster
     *
     * @param Cluster $cluster
     */
    public function removeCluster(Cluster $cluster)
    {
        $this->cluster->removeElement($cluster);
    }

    /**
     * Get cluster
     *
     * @return Collection
     */
    public function getCluster()
    {
        return $this->cluster;
    }
}
