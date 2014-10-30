Mesd\SettingsBundle\Model\Definition\DefinitionManager
---------------


**Class name**: DefinitionManager

**Namespace**: Mesd\SettingsBundle\Model\Definition







    Service for managing setting definitions.

    





Properties
----------


**$bundleStorage**

The storage locations avilable for
setting definition files.



    private array $bundleStorage






**$kernel**

Symfony kernerl interface



    private KernelInterface $kernel






Methods
-------


public **__construct** ( array $bundleStorage, KernelInterface $kernel )


Constructor








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $bundleStorage | array |  |
| $kernel | Symfony\Component\HttpKernel\KernelInterface |  |

--

public **buildFileName** ( Hive $hive, Cluster $cluster )


Builds a file name based on a hive [ and cluster ].








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hive | [Hive](Mesd-SettingsBundle-Entity-Hive.md) |  |
| $cluster | [Cluster](Mesd-SettingsBundle-Entity-Cluster.md) |  |

--

private **buildFileNameFromDefinition** ( SettingDefinition $settingDefinition )


Builds a file name based on SettingDefinition.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $settingDefinition | [SettingDefinition](Mesd-SettingsBundle-Model-Definition-SettingDefinition.md) |  |

--

public **createFile** ( string $fileName, string $filePath )


Create a fully qualified file path for a new definition file
and ensure that the directory structure is in place. The actual
file will be created in the saveFile() method.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $fileName | string |  |
| $filePath | string | &lt;p&gt;[optional]&lt;/p&gt; |

--

public **fileExists** ( string $file )


Determine if a given file exists








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $file | string |  |

--

public **loadFile** ( string $file )


Loads a setting definition file parses the yaml content
and returns a SettingDefinition object.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $file | string |  |

--

public **loadFileByHiveAndCluster** ( string $hive, string $cluster )


Loads a setting definition file by hive [ and cluster],
parses the yaml content, and returns a SettingDefinition object.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $hive | string |  |
| $cluster | string | &lt;p&gt;[optional]&lt;/p&gt; |

--

public **locateFile** ( string $fileName, string $filePath )


Locate a setting definition file

Checks $filePath
  -or-
Each bundle defined in settings config and the app/Resources
default path for a setting definition file. Returns the the
fully qualifed file name or false.






**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $fileName | string |  |
| $filePath | string |  |

--

public **saveFile** ( SettingDefinition $settingDefinition )


Saves a SettingDefinition to a yaml setting file. If the file
does not exist, it will be created. The SettingDefinition
will be validated before being saved.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $settingDefinition | [SettingDefinition](Mesd-SettingsBundle-Model-Definition-SettingDefinition.md) |  |

--

private **serialize** ( SettingDefinition $settingDefinition )


Serializes a SettingDefinition so it can be saved to
a yaml file.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $settingDefinition | [SettingDefinition](Mesd-SettingsBundle-Model-Definition-SettingDefinition.md) |  |

--

private **unserialize** ( string $fileContents, string $file )


Unserializes a setting definition yaml file, validates the
content, and converts the data into a SettingDefinition.








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $fileContents | string |  |
| $file | string |  |

--

public **getBundleStorage** (  )


Get bundleStorage

BundleStorage holds the aviable bundle paths and defualt
storage location for Setting Definition files.






--
