Mesd\SettingsBundle\Entity\Cluster
---------------


**Class name**: Cluster

**Namespace**: Mesd\SettingsBundle\Entity







    Cluster

    





Properties
----------


**$id**





    private integer $id






**$name**





    private string $name






**$description**





    private string $description






**$setting**





    private array $setting






**$hive**





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
| $setting | Mesd\SettingsBundle\Entity\Mesd\SettingsBundle\Model\Setting |  |

--

public **getSettingArray** (  )


Get setting Array








--

public **getSetting** ( $settingName )


Get setting








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $settingName | mixed |  |

--

public **removeSetting** ( Setting $setting )


Remove Setting








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $setting | Mesd\SettingsBundle\Entity\Mesd\SettingsBundle\Model\Setting |  |

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
