[Index](ApiIndex.md)


Mesd\SettingsBundle\Entity\Cluster
---------------


**Class name**: Cluster

**Namespace**: Mesd\SettingsBundle\Entity







    Cluster databse entity.

    





Properties
----------


**$id**

Cluster ID



    private integer $id






**$name**

Cluster name



    private string $name






**$description**

Cluster description



    private string $description






**$setting**

Cluster settings



    private array $setting






**$hive**

Hive parent to cluster



    private Hive $hive






Methods
-------


public **getId** (  )


Get id








--

public **setName** ( string $name )


Set name








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $name | string |  |

--

public **getName** (  )


Get name








--

public **setDescription** ( string $description )


Set description








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $description | string |  |

--

public **getDescription** (  )


Get description








--

public **addSetting** ( Setting $setting )


Add Setting








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $setting | [Setting](Mesd-SettingsBundle-Model-Setting.md) |  |

--

public **getSettingArray** (  )


Get setting Array








--

public **getSetting** ( string $settingName )


Get setting








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $settingName | string |  |

--

public **removeSetting** ( Setting $setting )


Remove Setting








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $setting | [Setting](Mesd-SettingsBundle-Model-Setting.md) |  |

--

public **setHive** ( Hive $hive )


Set hive








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hive | [Hive](Mesd-SettingsBundle-Entity-Hive.md) |  |

--

public **getHive** (  )


Get hive








--
