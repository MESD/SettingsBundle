##Install Fc/SettingsBundle

###Dependencies:

    "symfony/symfony": "2.3.*",
    "doctrine/orm": "~2.3"

###Install with composer:

    tbw


##Using FcSettingsBundle

###Understanding the terminology:

Related settings are stored in a group called a `cluster`. Each `cluster` is attached
to a `hive`. You can create as many hives and clusters as you need. You should think of
a `hive` as an application wide classification, and a `cluster` as sub-classification.


###Choosing the Definition Level - Hive or Cluster?:

You have two options when it comes to choosing the level at which your settings are
defined. `hive` or `cluster`. You must decide on the level when you define a new
`hive`. The default behavior is define settings at the `cluster` level. Normally
you'll want to define what settings exist, and their default values, at the cluster
level because each cluster has different types of settings. However, in some
situations each cluster will store the same type of settings, but with different
values. One example would be user settings. Each user would likely have the same
settings, but with different (or potentially different) values. In this situation,
you would want to define the settings at the `hive` level and store each user's
settings in a cluster.


###Create a new Hive with the console:

Since hives are designed to be application wide, you may only need a single `hive`.
If your application is rather large and can be broken down into sub-applications or
modules, you might create a `hive` for each sub-application or module.

**Note:**

> By default hives are created with the settings defined at the cluster level.
> If you would like your settings defined at the hive level, add the
> `--definedAtHive` option to the create hive command.


``` bash
$ app/console fc:setting:hive:create
```


###Create a new Cluster with the console:

Clusters are used to group like settings. For example if you had 5 settings that
controlled the theme of your application, you might create a **theme** `cluster`.


``` bash
$ app/console fc:setting:cluster:create
```


###Setting Definitions:

After you have created your `cluster`, or `hive` if defining at the `hive` level,
you can define your new settings. You can think of a setting definition as a *map*
that describes the available settings in the specific cluster (or hive), and helps
the system validate the setting data your application attempts to store. While the
settings themselves are stored in a database for fast and easy retrieval, the
definitions are stored as yaml files. By default the setting definition files are
stored in the `app/Resources/settings/` directory. The setting definition files
can also be stored within a bundle by placing the files in the bundles
`Resources/settings/` directory.

**Note:**
> The `app/Resources/settings/` directory will always be checked first, allowing
> you to override a vendor bundle's setting definition if needed.

When locating your setting definition files, the file locater will check the kernel
root `app/Resources/settings/` directory first, then in each bundle you specified
under *bundles* in the fc_settings section of your config.yml. If you set *auto_map*
to true, they system will check all bundles registered in your kernel, in the order
they have been registered. Therefore, you can override a setting definition file
from a bundle by placing a copy in your kernel root `app/Resources/settings/`
directory.

**Warning:**

> If you create the same setting definition file in multiple bundles, the system will
> only load the first definition file it locates.


Each `setting` has five descriptors:

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
$ app/console fc:setting:setting:define
```



###Next Steps

Now that you have completed the basic installation and configuration of the FcSettingsBundle,
you are ready to learn about more advanced features and usages of the bundle.

The following documents are available:

- [Setting Definitions - Programmers Reference](node-definition-programer-reference.md)