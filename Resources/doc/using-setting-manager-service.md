## Using the SettingManager Service


### Overview

The `SettingManager` service provides a single entry point for managing and
accessing your settings and related entities.

The first step is to get the `SettingManager` service. It's should be available
in any Symfony controller or class that implements the Symfony
`ContainerAwareInterface`.

```php
// Get SettingManager Service
$settingManger = $this->get('mesd_settings.setting_manager');
```

### Managing Hives

#### Create a new hive:

```php
// Create Hive, returns hive object or throws exception
// $settingManger->createHive($hiveName, $description = null, $definedAtHive = false);
$hive = $settingManger->createHive('application');

// Create Hive with description
// $settingManger->createHive($hiveName, $description = null, $definedAtHive = false);
$hive = $settingManger->createHive('application', 'Application Hive');

// Create Hive with settings defined at hive level
// $settingManger->createHive($hiveName, $description = null, $definedAtHive = false);
$hive = $settingManger->createHive('application', 'Application Hive', true);
```

#### Determine if a hive exists:

```php
// Check if specific hive exists, returns hive object or false
// $settingManger->hiveExists($hiveName);
$hive = $settingManger->hiveExists('application');
```

#### Load a hive:

```php
// Load a specific hive, returns hive object or throws exception
// $settingManger->loadHive($hiveName);
$hive = $settingManger->loadHive('application');
```

#### Determine if a hive has clusters:

```php
// Check if specific hive has clusters, returns hive object or false
// $settingManger->hiveHasClusters($hiveName);
$hive = $settingManger->hiveHasClusters('application');
```

#### Delete a hive:

```php
// Delete a specific hive, returns true or throws exception
// $settingManger->deleteHive($hiveName);
$settingManger->deleteHive('application');
```

#### Delete all clusters attched to a hive:

```php
// Delete a clusters attched to a specific hive, returns true or false
// $settingManger->deleteHiveClusters($hiveName);
$settingManger->deleteHiveClusters('application');
```

### Managing Clusters
--

#### Create a new cluster:

```php
// Create Cluster, returns cluster object or throws exception
// $settingManger->createCluster($hiveName, $clusterName, $description = null);
$cluster = $settingManger->createCluster('application', 'theme');

// Create Cluster with description
// $settingManger->createCluster($hiveName, $clusterName, $description = null);
$cluster = $settingManger->createCluster('application', 'theme', 'Theme Settings');
```

#### Determine if a cluster exists:

```php
// Check if specific cluster exists, returns cluster object or false
// $settingManger->clusterExists($hiveName, $clusterName);
$cluster = $settingManger->clusterExists('application', 'theme');
```

#### Load a cluster:

```php
// Load a specific cluster, returns cluster object or throws exception
// $settingManger->loadCluster($hiveName, $clusterName);
$cluster = $settingManger->loadCluster('application', 'theme');
```

#### Delete a cluster:

```php
// Delete a specific cluster, returns true or throws exception
// $settingManger->deleteCluster($hiveName, $clusterName);
$settingManger->deleteCluster('application', 'theme');
```

### Managing Settings

####Retrieve a setting from the database:

``` php
// Retrieve Setting Value
// $settingValue = $settingManger->loadSettingValue($hiveName, $clusterName, $settingName);
$fontSize = $settingManger->loadSettingValue('application', 'theme', 'font-size');

// Retrieve Setting Object
// $setting = $settingManger->loadSetting($hiveName, $clusterName, $settingName);
$setting = $settingManger->loadSetting('application', 'theme', 'font-size');

// Use the setting you retrieved
$fontSize = $setting->getValue();


// Retrieve Setting Object with Setting Definition Data
// $setting = $settingManger->loadSetting($hive, $cluster, $setting, $loadDefinition);
$setting = $settingManger->loadSetting('application', 'theme', 'font-size', true);

// Use the setting you retrieved
$fontSize = $setting->getValue();

// Use the setting definition you loaded
$settingDescription = $setting->getNodeDefinition()->getDescription();
$settingType        = $setting->getNodeDefinition()->getType();
```

**Note:**

> Loading the SettingNode definition requires loading information from the yaml
> setting definition file. This operation takes a little extra time. Therefore,
> the default behavior is to only load the setting name and value.


####Store a setting in the database:

``` php
// Store Setting Value
// $settingManger->saveSettingValue($hive, $cluster, $setting, $value);
$settingManger->saveSettingValue('application', 'theme', 'background', 'blue');

// Store a Setting Object
//   Load a setting
$fontSetting = $settingManger->loadSetting('application', 'theme', 'font-size');

//   Change the setting value
$fontSetting->setValue(14);

//   Store Setting
$settingManger->saveSetting($fontSetting);
```

**Note:**

> When you store a setting in the database it is automatically validated against the
> current setting definition.