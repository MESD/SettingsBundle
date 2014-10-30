Mesd\SettingsBundle\Model\Setting
---------------


**Class name**: Setting

**Namespace**: Mesd\SettingsBundle\Model







    Cluster setting after being unserialized from the database.

    





Properties
----------


**$name**

The setting name



    private string $name






**$value**

The setting value



    private mixed $value






**$settingNode**

SettingNode from the SettingDefinition



    private SettingNode $settingNode






**$cluster**

Cluster Entity



    private Cluster $cluster






Methods
-------


public **isSettingNodeLoaded** (  )


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

public **getName** (  )


Get Setting Name








--

public **setName** ( string $name )


Set Setting Name








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $name | string | &lt;p&gt;Setting Name&lt;/p&gt; |

--

public **getValue** (  )


Get Setting Value








--

public **setValue** ( mixed $value )


Set Setting Value








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $value | mixed |  |

--

public **getCluster** (  )


Get cluster








--

public **setCluster** ( Cluster $cluster )


Set cluster








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $cluster | [Cluster](Mesd-SettingsBundle-Entity-Cluster.md) |  |

--

public **getSettingNode** (  )


Get SettingNode definition

Get the SettingNode definition, if it has been loaded. See
isSettingNodeLoaded() for more details.






--

public **setSettingNode** ( SettingNode $settingNode )


Set SettingNode definition








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $settingNode | [SettingNode](Mesd-SettingsBundle-Model-Definition-SettingNode.md) |  |

--
