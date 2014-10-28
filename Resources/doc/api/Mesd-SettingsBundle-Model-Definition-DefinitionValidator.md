Mesd\SettingsBundle\Model\Definition\DefinitionValidator
===============






* Class name: DefinitionValidator
* Namespace: Mesd\SettingsBundle\Model\Definition





Properties
----------


### $definition

    private mixed $definition





* Visibility: **private**


### $settingsManager

    private mixed $settingsManager





* Visibility: **private**


Methods
-------


### __construct

    mixed Mesd\SettingsBundle\Model\Definition\DefinitionValidator::__construct(array $definition, $settingsManager)





* Visibility: **public**


#### Arguments
* $definition **array**
* $settingsManager **mixed**



### validate

    mixed Mesd\SettingsBundle\Model\Definition\DefinitionValidator::validate()





* Visibility: **public**




### validateStructure

    mixed Mesd\SettingsBundle\Model\Definition\DefinitionValidator::validateStructure()





* Visibility: **private**




### validateNodes

    mixed Mesd\SettingsBundle\Model\Definition\DefinitionValidator::validateNodes()





* Visibility: **private**




### validateNodeArray

    mixed Mesd\SettingsBundle\Model\Definition\DefinitionValidator::validateNodeArray($nodeName, $nodeAttributes, $key)





* Visibility: **private**


#### Arguments
* $nodeName **mixed**
* $nodeAttributes **mixed**
* $key **mixed**



### validateNodeBoolean

    mixed Mesd\SettingsBundle\Model\Definition\DefinitionValidator::validateNodeBoolean($nodeName, $nodeAttributes, $key)





* Visibility: **private**


#### Arguments
* $nodeName **mixed**
* $nodeAttributes **mixed**
* $key **mixed**



### validateNodeFloat

    mixed Mesd\SettingsBundle\Model\Definition\DefinitionValidator::validateNodeFloat($nodeName, $nodeAttributes, $key)





* Visibility: **private**


#### Arguments
* $nodeName **mixed**
* $nodeAttributes **mixed**
* $key **mixed**



### validateNodeInteger

    mixed Mesd\SettingsBundle\Model\Definition\DefinitionValidator::validateNodeInteger($nodeName, $nodeAttributes, $key)





* Visibility: **private**


#### Arguments
* $nodeName **mixed**
* $nodeAttributes **mixed**
* $key **mixed**



### validateNodeString

    mixed Mesd\SettingsBundle\Model\Definition\DefinitionValidator::validateNodeString($nodeName, $nodeAttributes, $key)





* Visibility: **private**


#### Arguments
* $nodeName **mixed**
* $nodeAttributes **mixed**
* $key **mixed**


