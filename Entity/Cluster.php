<?php

namespace Fc\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    private $dataSet;

    /**
     * @var \Fc\SettingsBundle\Entity\Hive
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
     * Set dataSet
     *
     * @param array $dataSet
     * @return Cluster
     */
    public function setDataSet($dataSet)
    {
        $this->dataSet = $dataSet;

        return $this;
    }

    /**
     * Get dataSet
     *
     * @return array
     */
    public function getDataSet()
    {
        return $this->dataSet;
    }

    /**
     * Set hive
     *
     * @param \Fc\SettingsBundle\Entity\Hive $hive
     * @return Cluster
     */
    public function setHive(\Fc\SettingsBundle\Entity\Hive $hive = null)
    {
        $this->hive = $hive;

        return $this;
    }

    /**
     * Get hive
     *
     * @return \Fc\SettingsBundle\Entity\Hive
     */
    public function getHive()
    {
        return $this->hive;
    }
}
