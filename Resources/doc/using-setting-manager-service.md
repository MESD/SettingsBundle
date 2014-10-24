## Using the SettingManager Service


### Overview

The `SettingManager` service provides a single entry point for managing and
accessing your settings and related entities.


### Managing Hives

#### Create a new hive

```php
// Get SettingManager Service
$settingManger = $this->get('mesd_settings.setting_manager');

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
