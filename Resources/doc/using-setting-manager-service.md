## Using the SettingManager Service


### Overview

The `SettingManager` service provides a single entry point for managing and
accessing your settings and related entities.

The first step is to get the `SettingManager` service. It's should be avilable
in any Symfony controller or class that implements the Symfony
`ContainerAwareInterface`.

```php
// Get SettingManager Service
$settingManger = $this->get('mesd_settings.setting_manager');
```

### Managing Hives

#### Create a new hive

```php
// Create Hive
// $settingManger->createHive($hiveName, $description = null, $definedAtHive = false);
$settingManger->createHive('application');

// Create Hive with description
// $settingManger->createHive($hiveName, $description = null, $definedAtHive = false);
$settingManger->createHive('application', 'Application Hive');

// Create Hive with settings defined at hive level
// $settingManger->createHive($hiveName, $description = null, $definedAtHive = false);
$settingManger->createHive('application', 'Application Hive', true);
```

#### Determine if a hive exisits

```php
// Check if specific hive exisits, returns hive object or false
// $settingManger->hiveExists($hiveName);
$hive = $settingManger->hiveExists('application');
```

#### Load a hive

```php
// Load a specific hive, returns hive object or throws exception
// $settingManger->loadHive($hiveName);
$hive = $settingManger->loadHive('application');
```

#### Determine if a hive has clusters

```php
// Check if specific hive has clusters, returns hive object or false
// $settingManger->hiveHasClusters($hiveName);
$hive = $settingManger->hiveHasClusters('application');
```

#### Delete a hive

```php
// Delete a specific hive, returns true or throws exception
// $settingManger->deleteHive($hiveName);
$settingManger->deleteHive('application');
```

