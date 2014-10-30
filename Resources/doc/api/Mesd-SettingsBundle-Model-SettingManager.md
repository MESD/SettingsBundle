Mesd\SettingsBundle\Model\SettingManager
---------------


**Class name**: SettingManager

**Namespace**: Mesd\SettingsBundle\Model







    Service for manging settings.

    





Properties
----------


**$objectManager**

Doctrine entity manger



    private ObjectManager $objectManager






**$definitionManager**

Setting definition manager service



    private DefinitionManager $definitionManager






Methods
-------


public **__construct** ( ObjectManager $objectManager, DefinitionManager $definitionManager )


Constructor








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $objectManager | Doctrine\Common\Persistence\ObjectManager |  |
| $definitionManager | [DefinitionManager](Mesd-SettingsBundle-Model-Definition-DefinitionManager.md) |  |

--

public **clusterExists** ( string $hiveName, string $clusterName )


Check if cluster exisits

Determines if the specified cluster exisits
in the database.






**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |
| $clusterName | string |  |

--

public **createCluster** ( string $hiveName, string $clusterName, string $description )


Creates a new cluster in database








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |
| $clusterName | string |  |
| $description | string |  |

--

public **createHive** ( string $hiveName, string $description, boolean $definedAtHive )


Creates a new hive in database








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |
| $description | string |  |
| $definedAtHive | boolean |  |

--

public **deleteCluster** ( string $hiveName, string $clusterName )


Delete the specified cluster or throw Exception.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |
| $clusterName | string |  |

--

public **deleteHive** ( string $hiveName )


Delete the specified hive or throw Exception.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |

--

public **deleteHiveClusters** ( string $hiveName )


Delete all the clusters attched to specific hive.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |

--

public **hiveExists** ( string $hiveName )


Determines if the specified hive exisits
in the database.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |

--

public **hiveHasClusters** ( string $hiveName )


Determines if the specified hive has clusters
exisiting in the database.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |

--

public **loadCluster** ( string $hiveName, string $clusterName )


Load the specified cluster or throw Exception.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |
| $clusterName | string |  |

--

public **loadHive** ( string $hiveName )


Load the specified hive or throw Exception.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |

--

public **loadSetting** ( string $hiveName, string $clusterName, string $settingName, boolean $loadDefinition )


Load the specified setting object or throw Exception.

Optionaly, load the SettingNode definition and set it within the
setting object. This operation requires extra resources and time,
and therefore should only be done when the SettingNode definition
is needed.






**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |
| $clusterName | string |  |
| $settingName | string |  |
| $loadDefinition | boolean | &lt;p&gt;[optional]&lt;/p&gt; |

--

public **loadSettingValue** ( string $hiveName, string $clusterName, string $settingName )


Load the specified setting value or throw Exception.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |
| $clusterName | string |  |
| $settingName | string |  |

--

public **saveSetting** ( mixed $setting )


Save the specified setting object or throw Exception.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $setting | mixed |  |

--

public **saveSettingValue** ( string $hiveName, string $clusterName, string $settingName, mixed $settingValue )


Save the specified setting value or throw Exception.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |
| $clusterName | string |  |
| $settingName | string |  |
| $settingValue | mixed |  |

--
