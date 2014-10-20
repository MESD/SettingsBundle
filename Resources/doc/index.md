##Install MesdSettingsBundle

###Dependencies:

    "symfony/symfony": "2.3.*",
    "doctrine/orm": "~2.3"

###Install with composer:


Add the bundle to your projects composer.json

``` json
"require": {
    "mesd/settings-bundle": "dev-master"
}
```

Install with composer

``` bash
$ composer update mesd/settings-bundle
```


###Enable the bundle:

``` php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Mesd\SettingsBundle\MesdSettingsBundle(),
    );
}
```


###Configure the bundle:

Now that the bundle is installed and enabled, you need to create a configuration entry
in your applications config.yml.


``` yaml
# app/config/config.yml

# SettingsBundle Configuration
mesd_settings:
    auto_map: false            # true/false - Scan all registered bundles for setting definitions
    #bundles:                   # Scan the following list of bundles for setting definitions
    #    AcmeDemoBundle:
    #    AcmeFooBundle:
```


##Understanding MesdSettingsBundle terminology:

###Hives and Clusters

Related settings are stored in an entity called a `cluster`. Each `cluster` is attached
to a parent entity called a `hive`. You can create as many hives and clusters as you
need. You should think of a `hive` as an application wide classification, and a `cluster`
as a sub-classification.


###Choosing the Definition Level - Hive or Cluster?:

You have two options when it comes to choosing the level at which your settings are
defined. `hive` or `cluster`. You must decide on the level when you define a new
`hive`. The default behavior is to define settings at the `cluster` level. Normally
you'll want to define what settings exist, and their default values, at the cluster
level because each cluster has different types of settings. However, in some
situations each cluster will store the same type of settings, but with different
values. One example would be user settings. Each user would likely have the same
settings, but with different (or potentially different) values. In this situation,
you would want to define the settings at the `hive` level and store each user's
settings in a cluster.


###Setting Definitions:

After you have created your `cluster` (or `hive` if defining at the `hive` level)
you can define your new settings. You can think of a setting definition as a map
that describes the available settings in the specific cluster. The definition helps
the system validate the setting data your application attempts to store. While the
settings themselves are stored in a database for fast and easy retrieval, the
definitions are stored as yaml files. Yaml files are easy to read and configure,
meaning you can create or update setting definitions using your text editor. There
is also a console command to define new settings if you prefer. By default the
setting definition files are stored in the kernel root `app/Resources/settings/`
directory. The setting definition files can also be stored within a bundle by
placing the files in the bundles `Resources/settings/` directory.


##Using MesdSettingsBundle

###Create a new Hive with the console:

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


###Create a new Cluster with the console:

Clusters are used to group like settings. For example if you had 5 settings that
controlled the theme of your application, you might create a **theme** `cluster`.


``` bash
$ app/console mesd:setting:cluster:create
```


###Create a Setting Definition:

Now you're ready to start defining your settings. You can define your settings by
creating a Yaml file for the cluster (or hive) or by using the symfony console
command. First lets look at where the Yaml files are located and what makes up
a setting definition node.

When locating your setting definition files, the file locater will check the kernel
root `app/Resources/settings/` directory first, then in each bundle you specified
under *bundles* in the fc_settings section of your config.yml. If you set *auto_map*
to true, the system will check all bundles registered in your kernel, in the order
they have been registered. Therefore, you can override a setting definition file
from a bundle by placing a copy in your kernel root `app/Resources/settings/`
directory.


**Note:**
> The `app/Resources/settings/` directory will always be checked first, allowing
> you to override a vendor bundle's setting definition if needed.


**Warning:**

> If you create the same setting definition file in multiple bundles, the system will
> only load the first definition file it locates.


Each `SettingNode` has five descriptors:

* **Name**: The setting *key* and how you'll lookup the setting.
* **Description**: A terse explanation of the setting [optional].
* **Type**: The settings data type. Currently supported:
    - String
    - Integer
    - Float
    - Boolean
    - Array
* **Format**: The string length, number of digits, number of decimals, etc.
* **Default**: The default value of the setting [optional].

**Note:**

> An `array` setting holds an array of values for each setting. Each array setting
> needs a `prototype` definition which defines the type of data contained within the
> array. The prototype must be one of the base types (integer, float, string, or
> boolean). The prototype definition must contain all of the format items the
> base type requires. i.e. String type requires a 'length' attribute.


###Define a new setting with the console:

``` bash
$ app/console mesd:setting:setting:define
```

###Store a setting in the database:

**Note:**

> When you store a setting in the database it is automatically validated with the
> current setting definition.

``` php

// Get Setting Manager Service
$settingManger = $this->get('mesd_settings.setting_manager');

// Store Setting
// $settingManger->saveSetting($hive, $cluster, $setting, $value);
$settingManger->saveSetting('application', 'theme', 'background', 'blue');

```

###Retrieve a setting from the database:

``` php
// Get Setting Manager Service
$settingManger = $this->get('mesd_settings.setting_manager');

// Retrieve Setting
// $setting = $settingManger->loadSetting($hive, $cluster, $setting);
$setting = $settingManger->loadSetting('application', 'theme', 'font-size');

```


The Setting Manager `loadSetting` method has an optional fourth parameter which
triggers whether the setting node definition is loaded as well. The setting node
definition contains the description, default value, and format data. Pass a
boolean `true` value to the fourth parameter to load the definition.


``` php
// Get Setting Manager Service
$settingManger = $this->get('mesd_settings.setting_manager');

// Retrieve Setting
// $setting = $settingManger->loadSetting($hive, $cluster, $setting, $loadDefinition);
$setting = $settingManger->loadSetting('application', 'theme', 'font-size', true);

```

**Note:**

> Loading the setting node definition requires loading information from the yaml
> setting definition file. This operation takes a little extra time. Therefore,
> the default behavior is to only load the setting name and value.


###Next Steps

Now that you have completed the basic installation and configuration of the FcSettingsBundle,
you are ready to learn about more advanced features and usages of the bundle.

The following documents are available:

- [Setting Definitions - Programmers Reference](node-definition-programer-reference.md)