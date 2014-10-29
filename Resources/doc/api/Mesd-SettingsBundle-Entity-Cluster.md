Mesd\SettingsBundle\Entity\Cluster
---------------

    Cluster

    


**Class name**: Cluster

**Namespace**: Mesd\SettingsBundle\Entity









Properties
----------


**$id** 



    private integer $id






**$name** 



    private string $name






**$description** 



    private string $description






**$setting** 



    private array $setting






**$hive** 



    private \Mesd\SettingsBundle\Entity\Hive $hive






Methods
-------


public **getId**

    integer Mesd\SettingsBundle\Entity\Cluster::getId()

Get id











public **setName**

    \Mesd\SettingsBundle\Entity\Cluster Mesd\SettingsBundle\Entity\Cluster::setName(string $name)

Set name









**Arguments**:
**$name** string 



public **getName**

    string Mesd\SettingsBundle\Entity\Cluster::getName()

Get name











public **setDescription**

    \Mesd\SettingsBundle\Entity\Cluster Mesd\SettingsBundle\Entity\Cluster::setDescription(string $description)

Set description









**Arguments**:
**$description** string 



public **getDescription**

    string Mesd\SettingsBundle\Entity\Cluster::getDescription()

Get description











public **addSetting**

    \Mesd\SettingsBundle\Entity\Cluster Mesd\SettingsBundle\Entity\Cluster::addSetting(\Mesd\SettingsBundle\Entity\Mesd\SettingsBundle\Model\Setting $setting)

Add Setting









**Arguments**:
**$setting** Mesd\SettingsBundle\Entity\Mesd\SettingsBundle\Model\Setting 



public **getSettingArray**

    array Mesd\SettingsBundle\Entity\Cluster::getSettingArray()

Get setting Array











public **getSetting**

    \Mesd\SettingsBundle\Entity\Mesd\SettingsBundle\Model\Setting Mesd\SettingsBundle\Entity\Cluster::getSetting($settingName)

Get setting









**Arguments**:
**$settingName** mixed 



public **removeSetting**

    \Mesd\SettingsBundle\Entity\Cluster Mesd\SettingsBundle\Entity\Cluster::removeSetting(\Mesd\SettingsBundle\Entity\Mesd\SettingsBundle\Model\Setting $setting)

Remove Setting









**Arguments**:
**$setting** Mesd\SettingsBundle\Entity\Mesd\SettingsBundle\Model\Setting 



public **setHive**

    \Mesd\SettingsBundle\Entity\Cluster Mesd\SettingsBundle\Entity\Cluster::setHive(\Mesd\SettingsBundle\Entity\Hive $hive)

Set hive









**Arguments**:
**$hive** [Mesd\SettingsBundle\Entity\Hive](Mesd-SettingsBundle-Entity-Hive.md) 



public **getHive**

    \Mesd\SettingsBundle\Entity\Hive Mesd\SettingsBundle\Entity\Cluster::getHive()

Get hive










