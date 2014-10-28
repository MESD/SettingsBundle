##Mesd\SettingsBundle\Entity\Hive

Hive




* Class name: Hive
* Namespace: Mesd\SettingsBundle\Entity





Properties
----------


### $id

    private integer $id





* Visibility: **private**


### $name

    private string $name





* Visibility: **private**


### $description

    private string $description





* Visibility: **private**


### $definedAtHive

    private boolean $definedAtHive





* Visibility: **private**


### $cluster

    private \Doctrine\Common\Collections\Collection $cluster





* Visibility: **private**


Methods
-------


### __construct

    mixed Mesd\SettingsBundle\Entity\Hive::__construct()

Constructor



* Visibility: **public**




### getId

    integer Mesd\SettingsBundle\Entity\Hive::getId()

Get id



* Visibility: **public**




### setName

    \Mesd\SettingsBundle\Entity\Hive Mesd\SettingsBundle\Entity\Hive::setName(string $name)

Set name



* Visibility: **public**


##### Arguments
* $name **string**



### getName

    string Mesd\SettingsBundle\Entity\Hive::getName()

Get name



* Visibility: **public**




### setDescription

    \Mesd\SettingsBundle\Entity\Hive Mesd\SettingsBundle\Entity\Hive::setDescription(string $description)

Set description



* Visibility: **public**


##### Arguments
* $description **string**



### getDescription

    string Mesd\SettingsBundle\Entity\Hive::getDescription()

Get description



* Visibility: **public**




### setDefinedAtHive

    \Mesd\SettingsBundle\Entity\Hive Mesd\SettingsBundle\Entity\Hive::setDefinedAtHive(boolean $definedAtHive)

Set definedAtHive



* Visibility: **public**


##### Arguments
* $definedAtHive **boolean**



### getDefinedAtHive

    boolean Mesd\SettingsBundle\Entity\Hive::getDefinedAtHive()

Get definedAtHive



* Visibility: **public**




### addCluster

    \Mesd\SettingsBundle\Entity\Hive Mesd\SettingsBundle\Entity\Hive::addCluster(\Mesd\SettingsBundle\Entity\Cluster $cluster)

Add cluster



* Visibility: **public**


##### Arguments
* $cluster **[Mesd\SettingsBundle\Entity\Cluster](Mesd-SettingsBundle-Entity-Cluster.md)**



### removeCluster

    mixed Mesd\SettingsBundle\Entity\Hive::removeCluster(\Mesd\SettingsBundle\Entity\Cluster $cluster)

Remove cluster



* Visibility: **public**


##### Arguments
* $cluster **[Mesd\SettingsBundle\Entity\Cluster](Mesd-SettingsBundle-Entity-Cluster.md)**



### getCluster

    \Doctrine\Common\Collections\Collection Mesd\SettingsBundle\Entity\Hive::getCluster()

Get cluster



* Visibility: **public**



