Mesd\SettingsBundle\Model\Setting
-----

    Setting
    
    Setting long description


**Class name**: Setting

**Namespace**: Mesd\SettingsBundle\Model


Properties
----------

**$name** The setting name

    private string $name


**$value** The setting value

    private mixed $value


**$settingNode** SettingNode from the SettingDefinition

    private \Mesd\SettingsBundle\Model\Definition\SettingNode $settingNode


**$cluster** Cluster Entity

    private \Mesd\SettingsBundle\Entity\Cluster $cluster


Methods
-------

public **isSettingNodeLoaded**

    boolean Mesd\SettingsBundle\Model\Setting::isSettingNodeLoaded()

Is SettingNode loaded

Determine if the SettingNode has been loaded.

The SettingManager loadSetting() method has an optional fourth parameter
which can be set to true if you would like the SettingNode definition to
be loaded when the setting is retrieved. This requires loading, parsing,
and validating the SettingDefinition Yaml file, which will take a little
extra time. Since the SettingNode definition data is not commonly needed
when retrieving settings and their values, the default behavior is to
not loaded the SettingNode.

--

public **getName**

    string Mesd\SettingsBundle\Model\Setting::getName()

Get Setting Name

--

public **setName**

    \Mesd\SettingsBundle\Model\Setting Mesd\SettingsBundle\Model\Setting::setName(string $name)

Set Setting Name

##### Arguments:
**$name** string - Setting Name

--

public **getValue**

    mixed Mesd\SettingsBundle\Model\Setting::getValue()

Get Setting Value

--

public **setValue**

    \Mesd\SettingsBundle\Model\Setting Mesd\SettingsBundle\Model\Setting::setValue(mixed $value)

Set Setting Value

##### Arguments
**$value** mixed - Setting Value

--

public **getCluster**

    \Mesd\SettingsBundle\Entity\Cluster Mesd\SettingsBundle\Model\Setting::getCluster()

Get cluster

--

public **setCluster**

    Mesd\SettingsBundle\Model\Setting::setCluster(\Mesd\SettingsBundle\Entity\Cluster $cluster)

##### Arguments
**$cluster** [Mesd\SettingsBundle\Entity\Cluster](Mesd-SettingsBundle-Entity-Cluster.md)

--

public **getSettingNode**

    \Mesd\SettingsBundle\Model\Definition\SettingNode|\Mesd\SettingsBundle\Model\Excption Mesd\SettingsBundle\Model\Setting::getSettingNode()

Get SettingNode definition

Get the SettingNode definition, if it has been loaded. See
isSettingNodeLoaded() for more details.

--

public **setSettingNode**

 Mesd\SettingsBundle\Model\Setting::setSettingNode(\Mesd\SettingsBundle\Model\Definition\SettingNode $settingNode)

Set SettingNode definition


##### Arguments
**$settingNode** [Mesd\SettingsBundle\Model\Definition\SettingNode](Mesd-SettingsBundle-Model-Definition-SettingNode.md)
