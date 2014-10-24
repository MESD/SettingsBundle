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

### Managing Clusters

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