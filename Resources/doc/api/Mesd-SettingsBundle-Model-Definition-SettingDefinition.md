Mesd\SettingsBundle\Model\Definition\SettingDefinition
---------------


**Class name**: SettingDefinition

**Namespace**: Mesd\SettingsBundle\Model\Definition







    Setting Definition once unserialized from yaml file.

    





Properties
----------


**$key**

Setting definition key



    private string $key






**$hiveName**

Setting definition hive name



    private string $hiveName






**$type**

Setting definition type



    private string $type






**$filePath**

Setting definition file path



    private string $filePath






**$settingNode**

Setting definition node collection



    private ArrayCollection $settingNode






Methods
-------


public **__construct** (  )


Constructor








--

public **getKey** (  )


Get setting definition key








--

public **setKey** ( string $key )


Set setting definition key








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $key | string |  |

--

public **getHiveName** (  )


Get setting definition hive name








--

public **setHiveName** ( string $hiveName )


Set setting definition hive name








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hiveName | string |  |

--

public **getType** (  )


Get setting definition type








--

public **setType** ( string $type )


Set setting definition type








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $type | string |  |

--

public **getFilePath** (  )


Get setting definition file path








--

public **setFilePath** ( string $filePath )


Set setting definition file path








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $filePath | string |  |

--

public **addSettingNode** ( SettingNode $settingNode )


Add SettingNode








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $settingNode | [SettingNode](Mesd-SettingsBundle-Model-Definition-SettingNode.md) |  |

--

public **getSettingNode** ( string $name )


Get SettingNode by node name








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $name | string |  |

--

public **getSettingNodes** (  )


Get all setting nodes








--

public **removeSettingNode** ( SettingNode $settingNode )


Remove setting node








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $settingNode | [SettingNode](Mesd-SettingsBundle-Model-Definition-SettingNode.md) |  |

--

public **removeSettingNodeByName** ( string $name )


Remove setting node by node name








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $name | string |  |

--
