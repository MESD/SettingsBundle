##Mesd\SettingsBundle\Entity\Cluster

Cluster




**Class name**: Cluster

**Namespace**: Mesd\SettingsBundle\Entity









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


### $setting

    private array $setting





* Visibility: **private**


### $hive

    private \Mesd\SettingsBundle\Entity\Hive $hive





* Visibility: **private**


Methods
-------


### getId

    integer Mesd\SettingsBundle\Entity\Cluster::getId()

Get id



* Visibility: **public**




### setName

    \Mesd\SettingsBundle\Entity\Cluster Mesd\SettingsBundle\Entity\Cluster::setName(string $name)

Set name



* Visibility: **public**


##### Arguments
* $name **string**



### getName

    string Mesd\SettingsBundle\Entity\Cluster::getName()

Get name



* Visibility: **public**




### setDescription

    \Mesd\SettingsBundle\Entity\Cluster Mesd\SettingsBundle\Entity\Cluster::setDescription(string $description)

Set description



* Visibility: **public**


##### Arguments
* $description **string**



### getDescription

    string Mesd\SettingsBundle\Entity\Cluster::getDescription()

Get description



* Visibility: **public**




### addSetting

    \Mesd\SettingsBundle\Entity\Cluster Mesd\SettingsBundle\Entity\Cluster::addSetting(\Mesd\SettingsBundle\Entity\Mesd\SettingsBundle\Model\Setting $setting)

Add Setting



* Visibility: **public**


##### Arguments
* $setting **Mesd\SettingsBundle\Entity\Mesd\SettingsBundle\Model\Setting**



### getSettingArray

    array Mesd\SettingsBundle\Entity\Cluster::getSettingArray()

Get setting Array



* Visibility: **public**




### getSetting

    \Mesd\SettingsBundle\Entity\Mesd\SettingsBundle\Model\Setting Mesd\SettingsBundle\Entity\Cluster::getSetting($settingName)

Get setting



* Visibility: **public**


##### Arguments
* $settingName **mixed**



### removeSetting

    \Mesd\SettingsBundle\Entity\Cluster Mesd\SettingsBundle\Entity\Cluster::removeSetting(\Mesd\SettingsBundle\Entity\Mesd\SettingsBundle\Model\Setting $setting)

Remove Setting



* Visibility: **public**


##### Arguments
* $setting **Mesd\SettingsBundle\Entity\Mesd\SettingsBundle\Model\Setting**



### setHive

    \Mesd\SettingsBundle\Entity\Cluster Mesd\SettingsBundle\Entity\Cluster::setHive(\Mesd\SettingsBundle\Entity\Hive $hive)

Set hive



* Visibility: **public**


##### Arguments
* $hive **[Mesd\SettingsBundle\Entity\Hive](Mesd-SettingsBundle-Entity-Hive.md)**



### getHive

    \Mesd\SettingsBundle\Entity\Hive Mesd\SettingsBundle\Entity\Cluster::getHive()

Get hive



* Visibility: **public**



