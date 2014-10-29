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


    







This method is defined by DefinitionManager


    **Arguments**:

    **$bundleStorage** mixed 
    **$kernel** mixed 
    **$settingManager** \Mesd\SettingsBundle\Model\SettingManager 


--


public **buildFileName** ( string $hiveName, string $clusterName )


    Builds a file name based on a hive [ and cluster ].







This method is defined by DefinitionManager


    **Arguments**:

    **$hiveName** string 
    **$clusterName** string 


--


private **buildFileNameFromDefinition** ( \Mesd\SettingsBundle\Model\Definition\SettingDefinition $SettingDefinition )


    Builds a file name based on SettingDefinition.







This method is defined by DefinitionManager


    **Arguments**:

    **$SettingDefinition** \Mesd\SettingsBundle\Model\Definition\SettingDefinition 


--


public **createFile** ( string $fileName, string $filePath )


    Create file path for new definition file

Create a fully qualified file path for a new definition file
and ensure that the directory structure is in place. The actual
file will be created in the saveFile() method.





This method is defined by DefinitionManager


    **Arguments**:

    **$fileName** string 
    **$filePath** string 


--


public **fileExists** ( string $file )


    Determine if a given file exists







This method is defined by DefinitionManager


    **Arguments**:

    **$file** string 


--


public **loadFile** ( string $hiveName, string $clusterName )


    Load a setting definition file

Loads a setting definition file by hive [ and cluster name ],
parses the yaml content, and returns a SettingDefinition object.





This method is defined by DefinitionManager


    **Arguments**:

    **$hiveName** string 
    **$clusterName** string 


--


public **locateFile** ( string $fileName, string $filePath )


    Locate a setting definition file

Checks $filePath
  -or-
Each bundle defined in settings config and the app/Resources
default path for a setting definition file. Returns the the
fully qualifed file name or false.





This method is defined by DefinitionManager


    **Arguments**:

    **$fileName** string 
    **$filePath** string 


--


public **saveFile** ( \Mesd\SettingsBundle\Model\Definition\SettingDefinition $settingDefinition )


    Save a SettingDefinition to a yaml file

Saves a SettingDefinition to a yaml setting file. If the file
does not exist, it will be created. The SettingDefinition
will be validated before being saved.





This method is defined by DefinitionManager


    **Arguments**:

    **$settingDefinition** \Mesd\SettingsBundle\Model\Definition\SettingDefinition 


--


private **serialize** ( \Mesd\SettingsBundle\Model\Definition\SettingDefinition $settingDefinition )


    Serialize a SettingDefinition

Serializes a SettingDefinition so it can be saved to
a yaml file.





This method is defined by DefinitionManager


    **Arguments**:

    **$settingDefinition** \Mesd\SettingsBundle\Model\Definition\SettingDefinition 


--


private **unserialize** ( string $fileContents, $file )


    Unserialize a setting definition yaml

Unserializes a setting definition yaml file, validates the
content, and converts the data into a SettingDefinition.





This method is defined by DefinitionManager


    **Arguments**:

    **$fileContents** string 
    **$file** mixed 


--


public **getBundleStorage** (  )


    Get bundleStorage

BundleStorage holds the aviable bundle paths and defualt
storage location for Setting Definition files.





This method is defined by DefinitionManager



--

