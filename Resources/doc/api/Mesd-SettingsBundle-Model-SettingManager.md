Mesd\SettingsBundle\Model\SettingManager
---------------

    

    


**Class name**: SettingManager

**Namespace**: Mesd\SettingsBundle\Model









Properties
----------


**$container** 



    private mixed $container






Methods
-------


public **__construct**

    mixed Mesd\SettingsBundle\Model\SettingManager::__construct(\Symfony\Component\DependencyInjection\ContainerInterface $container)











**Arguments**:
**$container** Symfony\Component\DependencyInjection\ContainerInterface 



public **clusterExists**

    \Mesd\SettingsBundle\Entity\Cluster|false Mesd\SettingsBundle\Model\SettingManager::clusterExists(string $hiveName, string $clusterName)

Check if cluster exisits

Determines if the specified cluster exisits
in the database.







**Arguments**:
**$hiveName** string 
**$clusterName** string 



public **createCluster**

    \Mesd\SettingsBundle\Entity\Cluster Mesd\SettingsBundle\Model\SettingManager::createCluster(string $hiveName, string $clusterName, string $description)

Create a cluster

Creates a new cluster in database







**Arguments**:
**$hiveName** string 
**$clusterName** string 
**$description** string 



public **createHive**

    \Mesd\SettingsBundle\Entity\Hive Mesd\SettingsBundle\Model\SettingManager::createHive(string $hiveName, string $description, boolean $definedAtHive)

Create a hive

Creates a new hive in database







**Arguments**:
**$hiveName** string 
**$description** string 
**$definedAtHive** boolean 



public **deleteCluster**

    true|\Mesd\SettingsBundle\Model\Exception Mesd\SettingsBundle\Model\SettingManager::deleteCluster(string $hiveName, string $clusterName)

Delete cluster

Delete the specified cluster or throw Exception.







**Arguments**:
**$hiveName** string 
**$clusterName** string 



public **deleteHive**

    true|\Mesd\SettingsBundle\Model\Exception Mesd\SettingsBundle\Model\SettingManager::deleteHive(string $hiveName)

Delete hive

Delete the specified hive or throw Exception.







**Arguments**:
**$hiveName** string 



public **deleteHiveClusters**

    true|false Mesd\SettingsBundle\Model\SettingManager::deleteHiveClusters(string $hiveName)

Delete hive clusters

Delete all the clusters attched to specific hive.







**Arguments**:
**$hiveName** string 



public **hiveExists**

    \Mesd\SettingsBundle\Entity\Hive|false Mesd\SettingsBundle\Model\SettingManager::hiveExists(string $hiveName)

Check if hive exisits

Determines if the specified hive exisits
in the database.







**Arguments**:
**$hiveName** string 



public **hiveHasClusters**

    \Mesd\SettingsBundle\Entity\Hive|false Mesd\SettingsBundle\Model\SettingManager::hiveHasClusters(string $hiveName)

Check if hive has clusters

Determines if the specified hive has clusters
exisiting in the database.







**Arguments**:
**$hiveName** string 



public **loadCluster**

    \Mesd\SettingsBundle\Entity\Cluster|\Mesd\SettingsBundle\Model\Exception Mesd\SettingsBundle\Model\SettingManager::loadCluster(string $hiveName, string $clusterName)

Load cluster

Load the specified cluster or throw Exception.







**Arguments**:
**$hiveName** string 
**$clusterName** string 



public **loadHive**

    \Mesd\SettingsBundle\Entity\Hive|\Mesd\SettingsBundle\Model\Exception Mesd\SettingsBundle\Model\SettingManager::loadHive(string $hiveName)

Load hive

Load the specified hive or throw Exception.







**Arguments**:
**$hiveName** string 



public **loadSetting**

    \Mesd\SettingsBundle\Model\Mesd\SettingsBundle\Model\Setting|\Mesd\SettingsBundle\Model\Exception Mesd\SettingsBundle\Model\SettingManager::loadSetting(string $hiveName, string $clusterName, string $settingName, boolean $loadDefinition)

Load setting

Load the specified setting object or throw Exception.

Optionaly, load the SettingNode definition and set it within the
setting object. This operation requires extra resources and time,
and therefore should only be done when the SettingNode definition
is needed.







**Arguments**:
**$hiveName** string 
**$clusterName** string 
**$settingName** string 
**$loadDefinition** boolean  - &lt;p&gt;(optional)&lt;/p&gt;



public **loadSettingValue**

    string|\Mesd\SettingsBundle\Model\Exception Mesd\SettingsBundle\Model\SettingManager::loadSettingValue(string $hiveName, string $clusterName, string $settingName)

Load setting value

Load the specified setting value or throw Exception.







**Arguments**:
**$hiveName** string 
**$clusterName** string 
**$settingName** string 



public **saveSetting**

    \Mesd\SettingsBundle\Model\Mesd\SettingsBundle\Model\Setting|\Mesd\SettingsBundle\Model\Exception Mesd\SettingsBundle\Model\SettingManager::saveSetting(mixed $setting)

Save setting

Save the specified setting object or throw Exception.







**Arguments**:
**$setting** mixed 



public **saveSettingValue**

    \Mesd\SettingsBundle\Model\Setting|\Mesd\SettingsBundle\Model\Exception Mesd\SettingsBundle\Model\SettingManager::saveSettingValue(string $hiveName, string $clusterName, string $settingName, mixed $settingValue)

Save setting value

Save the specified setting value or throw Exception.







**Arguments**:
**$hiveName** string 
**$clusterName** string 
**$settingName** string 
**$settingValue** mixed 


