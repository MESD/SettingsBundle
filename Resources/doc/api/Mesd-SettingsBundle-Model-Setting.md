Mesd\SettingsBundle\Model\Setting
===============






* Class name: Setting
* Namespace: Mesd\SettingsBundle\Model





Properties
----------


### $name

    private mixed $name





* Visibility: **private**


### $value

    private mixed $value





* Visibility: **private**


### $nodeDefinition

    private mixed $nodeDefinition





* Visibility: **private**


### $cluster

    private mixed $cluster





* Visibility: **private**


Methods
-------


### isNodeDefinitionLoaded

    boolean Mesd\SettingsBundle\Model\Setting::isNodeDefinitionLoaded()

Is SettingNode definition loaded

Determine if the SettingNode definition has been loaded.

The SettingManager loadSetting() method has an optional
fourth parameter which can be set to true if you would like
the SettingNode definition to be loaded when the setting is
retrieved. This requires loading, parsing, and validating
the SettingDefinition Yaml file, which will take a little
extra time. Since the SettingNode definition data is not
commonly needed when retrieving settings and their values,
the default behavior is to not loaded the SettingNode
definition.

* Visibility: **public**




### getName

    mixed Mesd\SettingsBundle\Model\Setting::getName()





* Visibility: **public**




### setName

    mixed Mesd\SettingsBundle\Model\Setting::setName($name)





* Visibility: **public**


#### Arguments
* $name **mixed**



### getValue

    mixed Mesd\SettingsBundle\Model\Setting::getValue()





* Visibility: **public**




### setValue

    mixed Mesd\SettingsBundle\Model\Setting::setValue($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### getCluster

    \Mesd\SettingsBundle\Model\Mesd\SettingsBundle\Entity\Cluster Mesd\SettingsBundle\Model\Setting::getCluster()

Get cluster



* Visibility: **public**




### setCluster

    mixed Mesd\SettingsBundle\Model\Setting::setCluster(\Mesd\SettingsBundle\Model\Mesd\SettingsBundle\Entity\Cluster $cluster)

Set cluster



* Visibility: **public**


#### Arguments
* $cluster **Mesd\SettingsBundle\Model\Mesd\SettingsBundle\Entity\Cluster**



### getNodeDefinition

    \Mesd\SettingsBundle\Model\Definition\SettingNode|null Mesd\SettingsBundle\Model\Setting::getNodeDefinition()

Get SettingNode definition

Get the SettingNode definition, if it has been
loaded. See isNodeDefinitionLoaded() below for
more details.

* Visibility: **public**




### setNodeDefinition

    \Mesd\SettingsBundle\Model\Definition\SettingNode Mesd\SettingsBundle\Model\Setting::setNodeDefinition(\Mesd\SettingsBundle\Model\Definition\SettingNode $settingNode)

Set SettingNode definition

Set the setting node definition.

* Visibility: **public**


#### Arguments
* $settingNode **[Mesd\SettingsBundle\Model\Definition\SettingNode](Mesd-SettingsBundle-Model-Definition-SettingNode.md)**


