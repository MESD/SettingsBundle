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
`hive`. The default is the `cluster` level. Normally you'll want to define what
settings exist, and their default values, at the cluster level because each cluster
has different kinds/types of settings. However, in some situations each cluster
will store the same kind/type of settings, but with different values. One example
would be user settings. Each user would likely have the same settings, but with
different (or potentially different) values. In this situation, you would want to
define the settings at the `hive` level and store each user's settings in a cluster.


###Create a new Hive:

Since hives are application wide, you may only need a single `hive`. If your application
is rather large and can be broken down into sub-applications or modules, you might create
a `hive` for each sub-application or module.

**Note:**

> By default hives are created with the settings defined at the cluster level.
> If youd like your settings defined at the hive level, add the `--definedAtHive`
> option to the create hive command.


``` bash
$ app/console fc:setting:hive:create
```


###Create a new Cluster:

Clusters are used to group like settings. For example if you had 5 settings that
controlled the theme of your application, you might create a **theme** `cluster`.


``` bash
$ app/console fc:setting:cluster:create
```


###Create a new Setting:

Each `setting` has four descriptors: `name`, `description`, `type`, and `format`.

* **Name**: Essentially the setting *key* and how you'll lookup the setting.
* **Description**: A terse explanation of the setting.
* **Type**: The settings data type. Currently supported:
    - String
    - Int
    - Float
    - Bool
    - Array
* **Format**: The string length, number of digits, number of decimals, etc.


###Setting Definition Files:

When locating your setting definition files, the file locatoer will check the kernel root
directory first, then in each bundle you specified under *bundles* in the fc_settings
section of your config.yml. If you set *auto_map* to true, they system will all bundles
register in your kernel, in the order they have been registered. Therefore, you can override
a setting definition file from a bundle, by placing a copy in your kernel root. Be aware that
if you create the same a definition file in mutiple bundles, the system will only load the
first definition file it locates.


###Next Steps

Now that you have completed the basic installation and configuration of the FcSettingsBundle,
you are ready to learn about more advanced features and usages of the bundle.

The following documents are available:

- [Setting Definitions - Programmers Reference](node-definition-programer-reference.md)