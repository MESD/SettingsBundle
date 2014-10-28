##Mesd\SettingsBundle\Model\Definition\DefinitionManager






* Class name: DefinitionManager
* Namespace: Mesd\SettingsBundle\Model\Definition





Properties
----------


### $bundleStorage

    private mixed $bundleStorage





* Visibility: **private**


### $kernel

    private mixed $kernel





* Visibility: **private**


### $settingManager

    private mixed $settingManager





* Visibility: **private**


Methods
-------


### __construct

    mixed Mesd\SettingsBundle\Model\Definition\DefinitionManager::__construct($bundleStorage, $kernel, \Mesd\SettingsBundle\Model\SettingManager $settingManager)





* Visibility: **public**


##### Arguments
* $bundleStorage **mixed**
* $kernel **mixed**
* $settingManager **[Mesd\SettingsBundle\Model\SettingManager](Mesd-SettingsBundle-Model-SettingManager.md)**



### buildFileName

    string Mesd\SettingsBundle\Model\Definition\DefinitionManager::buildFileName(string $hiveName, string $clusterName)

Builds a file name based on a hive [ and cluster ].



* Visibility: **public**


##### Arguments
* $hiveName **string**
* $clusterName **string**



### buildFileNameFromDefinition

    string Mesd\SettingsBundle\Model\Definition\DefinitionManager::buildFileNameFromDefinition(\Mesd\SettingsBundle\Model\Definition\SettingDefinition $SettingDefinition)

Builds a file name based on SettingDefinition.



* Visibility: **private**


##### Arguments
* $SettingDefinition **[Mesd\SettingsBundle\Model\Definition\SettingDefinition](Mesd-SettingsBundle-Model-Definition-SettingDefinition.md)**



### createFile

    string|\Mesd\SettingsBundle\Model\Definition\Exception Mesd\SettingsBundle\Model\Definition\DefinitionManager::createFile(string $fileName, string $filePath)

Create file path for new definition file

Create a fully qualified file path for a new definition file
and ensure that the directory structure is in place. The actual
file will be created in the saveFile() method.

* Visibility: **public**


##### Arguments
* $fileName **string**
* $filePath **string**



### fileExists

    boolean Mesd\SettingsBundle\Model\Definition\DefinitionManager::fileExists(string $file)

Determine if a given file exists



* Visibility: **public**


##### Arguments
* $file **string**



### loadFile

    \Mesd\SettingsBundle\Model\Definition\SettingDefinition Mesd\SettingsBundle\Model\Definition\DefinitionManager::loadFile(string $hiveName, string $clusterName)

Load a setting definition file

Loads a setting definition file by hive [ and cluster name ],
parses the yaml content, and returns a SettingDefinition object.

* Visibility: **public**


##### Arguments
* $hiveName **string**
* $clusterName **string**



### locateFile

    string|false Mesd\SettingsBundle\Model\Definition\DefinitionManager::locateFile(string $fileName, string $filePath)

Locate a setting definition file

Checks $filePath
  -or-
Each bundle defined in settings config and the app/Resources
default path for a setting definition file. Returns the the
fully qualifed file name or false.

* Visibility: **public**


##### Arguments
* $fileName **string**
* $filePath **string**



### saveFile

    string Mesd\SettingsBundle\Model\Definition\DefinitionManager::saveFile(\Mesd\SettingsBundle\Model\Definition\SettingDefinition $settingDefinition)

Save a SettingDefinition to a yaml file

Saves a SettingDefinition to a yaml setting file. If the file
does not exist, it will be created. The SettingDefinition
will be validated before being saved.

* Visibility: **public**


##### Arguments
* $settingDefinition **[Mesd\SettingsBundle\Model\Definition\SettingDefinition](Mesd-SettingsBundle-Model-Definition-SettingDefinition.md)**



### serialize

    array Mesd\SettingsBundle\Model\Definition\DefinitionManager::serialize(\Mesd\SettingsBundle\Model\Definition\SettingDefinition $settingDefinition)

Serialize a SettingDefinition

Serializes a SettingDefinition so it can be saved to
a yaml file.

* Visibility: **private**


##### Arguments
* $settingDefinition **[Mesd\SettingsBundle\Model\Definition\SettingDefinition](Mesd-SettingsBundle-Model-Definition-SettingDefinition.md)**



### unserialize

    \Mesd\SettingsBundle\Model\Definition\SettingDefinition Mesd\SettingsBundle\Model\Definition\DefinitionManager::unserialize(string $fileContents, $file)

Unserialize a setting definition yaml

Unserializes a setting definition yaml file, validates the
content, and converts the data into a SettingDefinition.

* Visibility: **private**


##### Arguments
* $fileContents **string**
* $file **mixed**



### getBundleStorage

    array Mesd\SettingsBundle\Model\Definition\DefinitionManager::getBundleStorage()

Get bundleStorage

BundleStorage holds the aviable bundle paths and defualt
storage location for Setting Definition files.

* Visibility: **public**



