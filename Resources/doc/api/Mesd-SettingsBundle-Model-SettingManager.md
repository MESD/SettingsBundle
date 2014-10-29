Mesd\SettingsBundle\Model\SettingManager
---------------


**Class name**: SettingManager

**Namespace**: Mesd\SettingsBundle\Model







    

    





Properties
----------


**$container**





    private  $container






Methods
-------


public **__construct** (  $container )











**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $container | Symfony\Component\DependencyInjection\ContainerInterface |  |

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


Create a cluster

Creates a new cluster in database






**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |
| $clusterName | string |  |
| $description | string |  |

--

public **createHive** ( string $hiveName, string $description, boolean $definedAtHive )


Create a hive

Creates a new hive in database






**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |
| $description | string |  |
| $definedAtHive | boolean |  |

--

public **deleteCluster** ( string $hiveName, string $clusterName )


Delete cluster

Delete the specified cluster or throw Exception.






**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |
| $clusterName | string |  |

--

public **deleteHive** ( string $hiveName )


Delete hive

Delete the specified hive or throw Exception.






**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |

--

public **deleteHiveClusters** ( string $hiveName )


Delete hive clusters

Delete all the clusters attched to specific hive.






**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |

--

public **hiveExists** ( string $hiveName )


Check if hive exisits

Determines if the specified hive exisits
in the database.






**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |

--

public **hiveHasClusters** ( string $hiveName )


Check if hive has clusters

Determines if the specified hive has clusters
exisiting in the database.






**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |

--

public **loadCluster** ( string $hiveName, string $clusterName )


Load cluster

Load the specified cluster or throw Exception.






**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |
| $clusterName | string |  |

--

public **loadHive** ( string $hiveName )


Load hive

Load the specified hive or throw Exception.






**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |

--

public **loadSetting** ( string $hiveName, string $clusterName, string $settingName, boolean $loadDefinition )


Load setting

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
| $loadDefinition | boolean | &lt;p&gt;(optional)&lt;/p&gt; |

--

public **loadSettingValue** ( string $hiveName, string $clusterName, string $settingName )


Load setting value

Load the specified setting value or throw Exception.






**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |
| $clusterName | string |  |
| $settingName | string |  |

--

public **saveSetting** ( mixed $setting )


Save setting

Save the specified setting object or throw Exception.






**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $setting | mixed |  |

--

public **saveSettingValue** ( string $hiveName, string $clusterName, string $settingName, mixed $settingValue )


Save setting value

Save the specified setting value or throw Exception.






**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |
| $clusterName | string |  |
| $settingName | string |  |
| $settingValue | mixed |  |

--
