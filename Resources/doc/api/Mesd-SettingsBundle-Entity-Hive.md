Mesd\SettingsBundle\Entity\Hive
---------------

> Hive

> 


**Class name**: Hive

**Namespace**: Mesd\SettingsBundle\Entity









Properties
----------


**$id** 



    private integer $id






**$name** 



    private string $name






**$description** 



    private string $description






**$definedAtHive** 



    private boolean $definedAtHive






**$cluster** 



    private \Doctrine\Common\Collections\Collection $cluster






Methods
-------


public **__construct**

    mixed Mesd\SettingsBundle\Entity\Hive::__construct()

Constructor











public **getId**

    integer Mesd\SettingsBundle\Entity\Hive::getId()

Get id











public **setName**

    \Mesd\SettingsBundle\Entity\Hive Mesd\SettingsBundle\Entity\Hive::setName(string $name)

Set name









**Arguments**:
**$name** string 



public **getName**

    string Mesd\SettingsBundle\Entity\Hive::getName()

Get name











public **setDescription**

    \Mesd\SettingsBundle\Entity\Hive Mesd\SettingsBundle\Entity\Hive::setDescription(string $description)

Set description









**Arguments**:
**$description** string 



public **getDescription**

    string Mesd\SettingsBundle\Entity\Hive::getDescription()

Get description











public **setDefinedAtHive**

    \Mesd\SettingsBundle\Entity\Hive Mesd\SettingsBundle\Entity\Hive::setDefinedAtHive(boolean $definedAtHive)

Set definedAtHive









**Arguments**:
**$definedAtHive** boolean 



public **getDefinedAtHive**

    boolean Mesd\SettingsBundle\Entity\Hive::getDefinedAtHive()

Get definedAtHive











public **addCluster**

    \Mesd\SettingsBundle\Entity\Hive Mesd\SettingsBundle\Entity\Hive::addCluster(\Mesd\SettingsBundle\Entity\Cluster $cluster)

Add cluster









**Arguments**:
**$cluster** [Mesd\SettingsBundle\Entity\Cluster](Mesd-SettingsBundle-Entity-Cluster.md) 



public **removeCluster**

    mixed Mesd\SettingsBundle\Entity\Hive::removeCluster(\Mesd\SettingsBundle\Entity\Cluster $cluster)

Remove cluster









**Arguments**:
**$cluster** [Mesd\SettingsBundle\Entity\Cluster](Mesd-SettingsBundle-Entity-Cluster.md) 



public **getCluster**

    \Doctrine\Common\Collections\Collection Mesd\SettingsBundle\Entity\Hive::getCluster()

Get cluster










