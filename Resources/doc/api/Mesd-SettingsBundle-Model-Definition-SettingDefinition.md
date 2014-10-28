##Mesd\SettingsBundle\Model\Definition\SettingDefinition






**Class name**: SettingDefinition

**Namespace**: Mesd\SettingsBundle\Model\Definition









Properties
----------


### $key

    private mixed $key





* Visibility: **private**


### $hive

    private mixed $hive





* Visibility: **private**


### $type

    private mixed $type





* Visibility: **private**


### $filePath

    private mixed $filePath





* Visibility: **private**


### $settingNode

    private mixed $settingNode





* Visibility: **private**


Methods
-------


### __construct

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::__construct()





* Visibility: **public**




### getKey

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::getKey()





* Visibility: **public**




### setKey

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::setKey($key)





* Visibility: **public**


##### Arguments
* $key **mixed**



### getHive

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::getHive()





* Visibility: **public**




### setHive

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::setHive($hive)





* Visibility: **public**


##### Arguments
* $hive **mixed**



### getType

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::getType()





* Visibility: **public**




### setType

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::setType($type)





* Visibility: **public**


##### Arguments
* $type **mixed**



### getFilePath

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::getFilePath()





* Visibility: **public**




### setFilePath

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::setFilePath($filePath)





* Visibility: **public**


##### Arguments
* $filePath **mixed**



### addSettingNode

    \Mesd\SettingsBundle\Model\Definition\SettingDefinition Mesd\SettingsBundle\Model\Definition\SettingDefinition::addSettingNode(\Mesd\SettingsBundle\Model\Definition\Mesd\SettingsBundle\Model\Definition\SettingNode $settingNode)

Add SettingNode



* Visibility: **public**


##### Arguments
* $settingNode **Mesd\SettingsBundle\Model\Definition\Mesd\SettingsBundle\Model\Definition\SettingNode**



### getSettingNode

    \Mesd\SettingsBundle\Model\Definition\Mesd\SettingsBundle\Model\Definition\SettingNode Mesd\SettingsBundle\Model\Definition\SettingDefinition::getSettingNode(string $name)

Get SettingNode



* Visibility: **public**


##### Arguments
* $name **string**



### getSettingNodes

    \Mesd\SettingsBundle\Model\Definition\Doctrine\Common\Collections\ArrayCollection() Mesd\SettingsBundle\Model\Definition\SettingDefinition::getSettingNodes()

Get SettingNodes



* Visibility: **public**




### removeSettingNode

    \Mesd\SettingsBundle\Model\Definition\SettingDefinition Mesd\SettingsBundle\Model\Definition\SettingDefinition::removeSettingNode(\Mesd\SettingsBundle\Model\Definition\Mesd\SettingsBundle\Model\Definition\SettingNode $settingNode)

Remove SettingNode



* Visibility: **public**


##### Arguments
* $settingNode **Mesd\SettingsBundle\Model\Definition\Mesd\SettingsBundle\Model\Definition\SettingNode**



### removeSettingNodeByName

    \Mesd\SettingsBundle\Model\Definition\SettingDefinition Mesd\SettingsBundle\Model\Definition\SettingDefinition::removeSettingNodeByName(string $name)

Remove SettingNode by name



* Visibility: **public**


##### Arguments
* $name **string**


