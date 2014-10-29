Mesd\SettingsBundle\Model\Definition\SettingDefinition
---------------

> 

> 


**Class name**: SettingDefinition

**Namespace**: Mesd\SettingsBundle\Model\Definition









Properties
----------


**$key** 



    private mixed $key






**$hive** 



    private mixed $hive






**$type** 



    private mixed $type






**$filePath** 



    private mixed $filePath






**$settingNode** 



    private mixed $settingNode






Methods
-------


public **__construct**

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::__construct()













public **getKey**

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::getKey()













public **setKey**

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::setKey($key)











**Arguments**:
**$key** mixed 



public **getHive**

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::getHive()













public **setHive**

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::setHive($hive)











**Arguments**:
**$hive** mixed 



public **getType**

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::getType()













public **setType**

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::setType($type)











**Arguments**:
**$type** mixed 



public **getFilePath**

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::getFilePath()













public **setFilePath**

    mixed Mesd\SettingsBundle\Model\Definition\SettingDefinition::setFilePath($filePath)











**Arguments**:
**$filePath** mixed 



public **addSettingNode**

    \Mesd\SettingsBundle\Model\Definition\SettingDefinition Mesd\SettingsBundle\Model\Definition\SettingDefinition::addSettingNode(\Mesd\SettingsBundle\Model\Definition\Mesd\SettingsBundle\Model\Definition\SettingNode $settingNode)

Add SettingNode









**Arguments**:
**$settingNode** Mesd\SettingsBundle\Model\Definition\Mesd\SettingsBundle\Model\Definition\SettingNode 



public **getSettingNode**

    \Mesd\SettingsBundle\Model\Definition\Mesd\SettingsBundle\Model\Definition\SettingNode Mesd\SettingsBundle\Model\Definition\SettingDefinition::getSettingNode(string $name)

Get SettingNode









**Arguments**:
**$name** string 



public **getSettingNodes**

    \Mesd\SettingsBundle\Model\Definition\Doctrine\Common\Collections\ArrayCollection() Mesd\SettingsBundle\Model\Definition\SettingDefinition::getSettingNodes()

Get SettingNodes











public **removeSettingNode**

    \Mesd\SettingsBundle\Model\Definition\SettingDefinition Mesd\SettingsBundle\Model\Definition\SettingDefinition::removeSettingNode(\Mesd\SettingsBundle\Model\Definition\Mesd\SettingsBundle\Model\Definition\SettingNode $settingNode)

Remove SettingNode









**Arguments**:
**$settingNode** Mesd\SettingsBundle\Model\Definition\Mesd\SettingsBundle\Model\Definition\SettingNode 



public **removeSettingNodeByName**

    \Mesd\SettingsBundle\Model\Definition\SettingDefinition Mesd\SettingsBundle\Model\Definition\SettingDefinition::removeSettingNodeByName(string $name)

Remove SettingNode by name









**Arguments**:
**$name** string 


