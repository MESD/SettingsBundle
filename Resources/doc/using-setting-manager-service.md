## Using the SettingManager Service


### Overview

The `SettingManager` service provides a single entry point for managing and
accessing your settings and related entities.

The first step is to get the `SettingManager` service. It's should be available
in any Symfony controller or class that implements the Symfony
`ContainerAwareInterface`.

```php
// Get SettingManager Service
$settingManager = $this->get('mesd_settings.setting_manager');
```

--
### Managing Hives

#### Create a new hive:

```php
// Create Hive, returns hive object or throws exception
// $settingManager->createHive($hiveName, $description = null, $definedAtHive = false);
$hive = $settingManager->createHive('application');

// Create Hive with description
// $settingManager->createHive($hiveName, $description = null, $definedAtHive = false);
$hive = $settingManager->createHive('application', 'Application Hive');

// Create Hive with settings defined at hive level
// $settingManager->createHive($hiveName, $description = null, $definedAtHive = false);
$hive = $settingManager->createHive('application', 'Application Hive', true);
```

#### Determine if a hive exists:

```php
// Check if specific hive exists, returns hive object or false
// $settingManager->hiveExists($hiveName);
$hive = $settingManager->hiveExists('application');
```

#### Load a hive:

```php
// Load a specific hive, returns hive object or throws exception
// $settingManager->loadHive($hiveName);
$hive = $settingManager->loadHive('application');
```

#### Determine if a hive has clusters:

```php
// Check if specific hive has clusters, returns hive object or false
// $settingManager->hiveHasClusters($hiveName);
$hive = $settingManager->hiveHasClusters('application');
```

#### Delete a hive:

```php
// Delete a specific hive, returns true or throws exception
// $settingManager->deleteHive($hiveName);
$settingManager->deleteHive('application');
```

#### Delete all clusters attached to a hive:

```php
// Delete a clusters attached to a specific hive, returns true or false
// $settingManager->deleteHiveClusters($hiveName);
$settingManager->deleteHiveClusters('application');
```

--
### Managing Clusters

#### Create a new cluster:

```php
// Create Cluster, returns cluster object or throws exception
// $settingManager->createCluster($hiveName, $clusterName, $description = null);
$cluster = $settingManager->createCluster('application', 'theme');

// Create Cluster with description
// $settingManager->createCluster($hiveName, $clusterName, $description = null);
$cluster = $settingManager->createCluster('application', 'theme', 'Theme Settings');
```

#### Determine if a cluster exists:

```php
// Check if specific cluster exists, returns cluster object or false
// $settingManager->clusterExists($hiveName, $clusterName);
$cluster = $settingManager->clusterExists('application', 'theme');
```

#### Load a cluster:

```php
// Load a specific cluster, returns cluster object or throws exception
// $settingManager->loadCluster($hiveName, $clusterName);
$cluster = $settingManager->loadCluster('application', 'theme');
```

#### Delete a cluster:

```php
// Delete a specific cluster, returns true or throws exception
// $settingManager->deleteCluster($hiveName, $clusterName);
$settingManager->deleteCluster('application', 'theme');
```

--
### Managing Settings

####Retrieve a setting from the database:

``` php
// Retrieve Setting Value
// $settingValue = $settingManager->loadSettingValue($hiveName, $clusterName, $settingName);
$fontSize = $settingManager->loadSettingValue('application', 'theme', 'font-size');

// Retrieve Setting Object
// $setting = $settingManager->loadSetting($hiveName, $clusterName, $settingName);
$setting = $settingManager->loadSetting('application', 'theme', 'font-size');

// Use the setting you retrieved
$fontSize = $setting->getValue();


// Retrieve Setting Object with Setting Definition Data
// $setting = $settingManager->loadSetting($hive, $cluster, $setting, $loadDefinition);
$setting = $settingManager->loadSetting('application', 'theme', 'font-size', true);

// Use the setting you retrieved
$fontSize = $setting->getValue();

// Use the setting definition you loaded
$settingDescription = $setting->getSettingNode()->getDescription();
$settingType        = $setting->getSettingNode()->getType();
```

**Note:**

> Loading the SettingNode definition requires loading information from the yaml
> setting definition file. This operation takes a little extra time. Therefore,
> the default behavior is to only load the setting name and value.


####Store a setting in the database:

``` php
// Store Setting Value
// $settingManager->saveSettingValue($hive, $cluster, $setting, $value);
$settingManager->saveSettingValue('application', 'theme', 'background', 'blue');

// Store a Setting Object
//   Load a setting
$fontSetting = $settingManager->loadSetting('application', 'theme', 'font-size');

//   Change the setting value
$fontSetting->setValue(14);

//   Store Setting
$settingManager->saveSetting($fontSetting);
```

**Note:**

> When you store a setting in the database it is automatically validated against the
> current setting definition.