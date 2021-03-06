## Install MesdSettingsBundle

### Dependencies:

    "symfony/symfony": "2.3.*",
    "doctrine/orm": "~2.3"

### Install with composer:


Add the bundle to your project

``` bash
$ composer require mesd/settings-bundle "~1.0"

```


### Enable the bundle:

``` php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Mesd\SettingsBundle\MesdSettingsBundle()
    );
}
```


### Configure the bundle:

Now that the bundle is installed and enabled, you need to create a configuration entry
in your applications config.yml.

``` yaml
# app/config/config.yml

# MesdSettingsBundle Configuration
mesd_settings:
    auto_map: false        # true/false - Scan all registered bundles for setting definitions
    #bundles:              # Scan the following list of bundles for setting definitions
    #    AcmeDemoBundle:
    #    AcmeFooBundle:
```

The MesdSettingsBundle uses yaml files to store Setting Definitions, which essentially are
the blueprint for your settings. You'll learn more about Setting Definitions in a minute.
These configuration options tell the MesdSettingsBundle where to locate your setting
definition files. To start, just leave `auto_map` set to false, and the `bundles` section
commented out. Once you have a better understanding of how things work, you can revisit
config.yml file and make any needed adjustments.


### Create entities in the database:

Last, you just need to create the entities used for the MesdSettingsBundle in your
database.

Use the Doctrine Schema Update tool to list the changes needed:

```bash
$ app/console doctrine:schema:update --dump-sql
```

There should be just two tables created `setting_hive` and `setting_cluster`, and one
foreign key. If everything looks good, go ahead and run the command again, this time
making the changes in the database:

```bash
$ app/console doctrine:schema:update --force
```


## Understanding MesdSettingsBundle terminology:

### Hives and Clusters

Related settings are stored in an entity called a `cluster`. Each `cluster` is attached
to a parent entity called a `hive`. You can create as many hives and clusters as you
need. You should think of a `hive` as an application wide classification, and a `cluster`
as a group for related settings. If your application is rather large and can be broken down
into sub-applications or modules, you might create a `hive` for each sub-application or
module.


### Choosing the Definition Level - Hive or Cluster?:

You have two options when it comes to choosing the level at which your settings are
defined. `hive` or `cluster`. You must decide on the level when you define a new
`hive`. The default behavior is to define settings at the `cluster` level. Normally
you'll want to define what settings exist, and their default values, at the cluster
level because each cluster has different types of settings. However, in some
situations each cluster will store the same type of settings, but with different
values. One example would be user settings. Each user would have the same settings,
but with different (or potentially different) values. In this situation, you would
want to define the settings at the `hive` level and store each user's settings in a
cluster.

![Settings defined at Cluster vs Hive](/Resources/doc/img/settingsDefinedAt.png)

### Setting Definitions:

After you have created your `cluster` (or `hive` if defining at the `hive` level)
you can define your new settings. You can think of a setting definition as a map
that describes the available settings in a specific cluster. The definition helps
the system validate the setting data your application attempts to store.

While the settings themselves are stored in a database for fast and easy retrieval,
the definitions are stored as yaml files. Yaml files are easy to read and
configure, meaning you can create or update setting definitions using your text
editor. There is also a console command to define new settings if you prefer a more
automated approach.

By default the setting definition files are stored in the kernel root
`app/Resources/settings/` directory. The setting definition files can also be
stored within a bundle by placing the files in the bundles `Resources/settings/`
directory, and then updating your config.yml to let the MesdSettingsBundle know to
scan the bundle for setting definitions.

The naming convention for setting definition files is `hiveName-clusterName.yml`.
If the settings are defined at the hive, then the cluster is left off and the file
name pattern is `hiveName.yml`. Here is an example of a setting definition file:

```yaml
// app/Resources/settings/application-theme.yml

theme:                 // clusterName on definition type cluster, hiveName for definition type hive
    hive: application
    type: cluster      // Definition level: hive or cluster
    nodes:
        background:
            default: 'light-gray'
            description: 'Theme Background Color'
            type: string
            length: 25
        color:
            default: 'blue'
            description: 'Theme Font Color'
            type: string
            length: 25
        font-size:
            default: 12
            description: 'Theme font size in pixels'
            type: integer
            digits: 2
        dashboard-widgets:
            default:
                - 'SalesPieChart'
                - 'RecentNotifications'
                - 'Favorites'
            description: 'Theme dashboard widgets'
            type: array
            prototype:
                type: string
                length: 255
```


## Using MesdSettingsBundle

### Create a new Hive with the console:

Since hives are designed to be application wide, you may only need a single `hive`.
If your application is rather large and can be broken down into sub-applications or
modules, you might create a `hive` for each sub-application or module.

**Note:**

> By default hives are created with the settings defined at the cluster level.
> If you would like your settings defined at the hive level, add the
> `--definedAtHive` option to the create hive command.


``` bash
$ app/console mesd:setting:hive:create
```


### Create a new Cluster with the console:

Clusters are used to group like settings. For example if you had 5 settings that
controlled the theme of your application, you might create a *theme* `cluster`.


``` bash
$ app/console mesd:setting:cluster:create
```


### Create a Setting Definition:

Now you're ready to start defining your settings. You can define your settings by
creating a yaml file for the cluster (or hive) or by using the symfony console
command. First lets look at where the yaml files are located and what makes up
a setting definition node.

When locating your setting definition files, the file locater will check the kernel
root `app/Resources/settings/` directory first, then in each bundle you specified
under *bundles* in the mesd_settings section of your config.yml. If you set *auto_map*
to true, the system will check all bundles registered in your kernel, in the order
they have been registered. Therefore, you can override a setting definition file
from a bundle by placing a copy in your kernel root `app/Resources/settings/`
directory.


**Note:**
> The `app/Resources/settings/` directory will always be checked first, allowing
> you to override a vendor bundle's setting definition if needed.


**Warning:**

> If you create the same setting definition file in multiple bundles, the system will
> only load the first definition file it locates. The bundles are scanned based on the
> order the bundles were specified in the mesd_settings section of config.yml, or
> AppKernel.php if auto_map is set to true.


Each `SettingNode` has five descriptors:

* **Name**: The setting *key* and how you'll lookup the setting.
* **Description**: A terse explanation of the setting [optional].
* **Type**: The settings data type. Currently supported:
    - String
    - Integer
    - Float
    - Boolean
    - Array
* **Format**: The string length, number of digits, decimal precision, etc.
* **Default**: The default value of the setting [optional].

**Note:**

> An `array` setting holds an array of values for each setting. Each array setting
> needs a `prototype` definition which defines the type of data contained within the
> array. The prototype must be one of the base types (integer, float, string, or
> boolean). The prototype definition must contain all of the format items the
> base type requires. e.g. String type requires a 'length' attribute.


### Define a new setting with the console:

``` bash
$ app/console mesd:setting:setting:define
```


### Setting Validation - Insert setting base data or validate changes:

When you define a new setting or change an existing setting definition, you need to
ensure the clusters in the database are in-sync. Run the setting validation command
to check the clusters and make any needed updates. The validation command will not
make any changes to the clusters without prompting you for confirmation of the
needed change.

The validate process will prompt the user for confirmation on any required changes
to settings in the database. There are three types of changes that could be
required:

```text
   Insert - New settings that have been defined, but don't exist in database.
            Inserts should not be destructive to existing data.

   Update - Changes to the setting definition that need to be applied to
            settings in the database. Updates can potentially be destructive
            to existing data. i.e. Format change where value is no longer
            compatible.

   Delete - Removed nodes from setting definition that need to be purged from
            the settings in the database. Deletes are always destructive to
            existing data.
```

**Note:**

> If you have a large number of changes that need to be made and you don't want the
> system to prompt you for every change, you can use the --forceInsert, --forceUpdate,
> --forceDelete, or --forceAll command line options. However, the system will make
> all the necessary changes without asking for any confirmation.

**Warning:**

> When the validation command attempts to update a setting to match the definition,
> it will attempt to convert data when the new format has a type of string. Otherwise
> the current setting value will be replaced with the default value from the
> definition.

Validate the settings with the symfony console command:

``` bash
$ app/console mesd:setting:setting:validate
```

### Retrieve a setting from the database:

There are two ways to retrieve setting data. The first method loads just the setting
value.

``` php
// Get SettingManager Service
$settingManager = $this->get('mesd_settings.setting_manager');

// Retrieve Setting Value
// $settingValue = $settingManager->loadSettingValue($hiveName, $clusterName, $settingName);
$fontSize = $settingManager->loadSettingValue('application', 'theme', 'font-size');

```

The second method loads the setting object.

``` php
// Get SettingManager Service
$settingManager = $this->get('mesd_settings.setting_manager');

// Retrieve Setting
// $setting = $settingManager->loadSetting($hiveName, $clusterName, $settingName);
$setting = $settingManager->loadSetting('application', 'theme', 'font-size');

// Use the setting you retrieved
$fontSize = $setting->getValue();

```

The Setting Manager `loadSetting` method has an optional fourth parameter which
triggers whether the `SettingNode` definition is loaded as well. The `SettingNode`
definition contains the description, default value, and format data of the setting.
Pass a boolean `true` value to the fourth parameter to load the definition.


``` php
// Get SettingManager Service
$settingManager = $this->get('mesd_settings.setting_manager');

// Retrieve Setting
// $setting = $settingManager->loadSetting($hive, $cluster, $setting, $loadDefinition);
$setting = $settingManager->loadSetting('application', 'theme', 'font-size', true);

// Use the setting you retrieved
$fontSize = $setting->getValue();

// Use the setting definition you loaded
$settingDescription = $setting->getSettingNode()->getDescription();
```

**Note:**

> Loading the SettingNode definition requires loading information from the yaml
> setting definition file. This operation takes a little extra time. Therefore,
> the default behavior is to only load the setting name and value.


###Store a setting in the database:

Just like with retrieving settings, there are two methods for saving settings. The
first method saves the value without the need to load or create a setting object.

``` php
// Get SettingManager Service
$settingManager = $this->get('mesd_settings.setting_manager');

// Store Setting Value
// $settingManager->saveSettingValue($hive, $cluster, $setting, $value);
$settingManager->saveSettingValue('application', 'theme', 'background', 'blue');
```

The second method accepts the setting object to be saved. This is convenient when you
already have the setting object loaded.

``` php
// Get SettingManager Service
$settingManager = $this->get('mesd_settings.setting_manager');

// Load a setting
$fontSetting = $settingManager->loadSetting('application', 'theme', 'font-size');

// Change the setting value
$fontSetting->setValue(14);

// Store Setting
$settingManager->saveSetting($fontSetting);
```

**Note:**

> When you store a setting in the database it is automatically validated against the
> current setting definition.

### Next Steps

Now that you have completed the installation, configuration, and basic usage of the
MesdSettingsBundle, you are ready to learn about more advanced features and usage of
the bundle.

The following additional documents are available:

- [Using the SettingManager Service](using-setting-manager-service.md)
- [Using the DefinitionManager Service](using-definition-manager-service.md)
- [Storing User Settings](storing-user-settings.md)
- [API Docs](api/ApiIndex.md)
