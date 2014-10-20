<?php

namespace Mesd\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hive
 */
class Hive
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
     * @var boolean
     */
    private $definedAtHive;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $cluster;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cluster = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \Mesd\SettingsBundle\Entity\Cluster $cluster
     * @return Hive
     */
    public function addCluster(\Mesd\SettingsBundle\Entity\Cluster $cluster)
    {
        $this->cluster[] = $cluster;

        return $this;
    }

    /**
     * Remove cluster
     *
     * @param \Mesd\SettingsBundle\Entity\Cluster $cluster
     */
    public function removeCluster(\Mesd\SettingsBundle\Entity\Cluster $cluster)
    {
        $this->cluster->removeElement($cluster);
    }

    /**
     * Get cluster
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCluster()
    {
        return $this->cluster;
    }
}
