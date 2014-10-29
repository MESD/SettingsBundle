Mesd\SettingsBundle\Model\Definition\DefinitionManager
---------------

    

    


**Class name**: DefinitionManager

**Namespace**: Mesd\SettingsBundle\Model\Definition









Properties
----------


**$bundleStorage** - 



    private mixed $bundleStorage






**$kernel** - 



    private mixed $kernel






**$settingManager** - 



    private mixed $settingManager






Methods
-------


public **__construct** ( $bundleStorage, $kernel, \Mesd\SettingsBundle\Model\SettingManager $settingManager )


    








**Arguments**:

$bundleStorage mixed 
$kernel mixed 
$settingManager [Mesd\SettingsBundle\Model\SettingManager](Mesd-SettingsBundle-Model-SettingManager.md) 


--


public **buildFileName** ( string $hiveName, string $clusterName )


    Builds a file name based on a hive [ and cluster ].








**Arguments**:

$hiveName string 
$clusterName string 


--


private **buildFileNameFromDefinition** ( \Mesd\SettingsBundle\Model\Definition\SettingDefinition $SettingDefinition )


    Builds a file name based on SettingDefinition.








**Arguments**:

$SettingDefinition [Mesd\SettingsBundle\Model\Definition\SettingDefinition](Mesd-SettingsBundle-Model-Definition-SettingDefinition.md) 


--


public **createFile** ( string $fileName, string $filePath )


    Create file path for new definition file

Create a fully qualified file path for a new definition file
and ensure that the directory structure is in place. The actual
file will be created in the saveFile() method.






**Arguments**:

$fileName string 
$filePath string 


--


public **fileExists** ( string $file )


    Determine if a given file exists








**Arguments**:

$file string 


--


public **loadFile** ( string $hiveName, string $clusterName )


    Load a setting definition file

Loads a setting definition file by hive [ and cluster name ],
parses the yaml content, and returns a SettingDefinition object.






**Arguments**:

$hiveName string 
$clusterName string 


--


public **locateFile** ( string $fileName, string $filePath )


    Locate a setting definition file

Checks $filePath
  -or-
Each bundle defined in settings config and the app/Resources
default path for a setting definition file. Returns the the
fully qualifed file name or false.






**Arguments**:

$fileName string 
$filePath string 


--


public **saveFile** ( \Mesd\SettingsBundle\Model\Definition\SettingDefinition $settingDefinition )


    Save a SettingDefinition to a yaml file

Saves a SettingDefinition to a yaml setting file. If the file
does not exist, it will be created. The SettingDefinition
will be validated before being saved.






**Arguments**:

$settingDefinition [Mesd\SettingsBundle\Model\Definition\SettingDefinition](Mesd-SettingsBundle-Model-Definition-SettingDefinition.md) 


--


private **serialize** ( \Mesd\SettingsBundle\Model\Definition\SettingDefinition $settingDefinition )


    Serialize a SettingDefinition

Serializes a SettingDefinition so it can be saved to
a yaml file.






**Arguments**:

$settingDefinition [Mesd\SettingsBundle\Model\Definition\SettingDefinition](Mesd-SettingsBundle-Model-Definition-SettingDefinition.md) 


--


private **unserialize** ( string $fileContents, $file )


    Unserialize a setting definition yaml

Unserializes a setting definition yaml file, validates the
content, and converts the data into a SettingDefinition.






**Arguments**:

$fileContents string 
$file mixed 


--


public **getBundleStorage** (  )


    Get bundleStorage

BundleStorage holds the aviable bundle paths and defualt
storage location for Setting Definition files.







--

