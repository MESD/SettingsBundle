##Install Fc/SettingsBundle

###Dependencies:

    "symfony/symfony": "2.3.*",
    "doctrine/orm": "~2.3"

###Install with composer:

    tbw


##Using Fc/SettingsBundle

###Understanding the terminology:

Related settings are stored in a group called a `cluster`. Each `cluster` is attached
to a `hive`. You can create as many hives and clusters as you need. You should think of
a `hive` as an application wide classification, and a `cluster` as sub-classification.


###Create a new Hive:

Since hives are application wide, you may only need a few or even a single `hive`. If
your application is rather large and can be broken down into sub-applications, you
might create a `hive` for each sub-application.


###Create a new Cluster:

Clusters are used to group like settings. For example if you had 5 settings that
controlled the theme of your application, you might create a `theme` `cluster`.


###Create a new Setting:

Each `setting` has four descriptors: `name`, `description`, `type`, and `format`.

* Name: Esentialy the setting *key*, how you'll lookup the setting.
* Description: A terse explanation of the setting.
* Type: The settings data type. Currently supported:
    - String
    - Int
    - Float
    - Bool
* Format: The string length, number of digits, number of decimals, etc.


###Setting Definition Level - Hive or Cluster?:

You have two options when it comes to choosing the level at which your settings are
defined. `hive` or `cluster`. You must decide on the level when you define a new
`hive`. The default is the `cluster` level. Normally you'll want to define what
settings exist, and their default values, at the cluster level because each cluster
has different kinds/types of settings. However, in some situations each cluster
will store the same kind/type of settings, but with different values. One example
would be user settings. Each user would likely have the same settings, but with
different (or potentially different) values. In this situation, would would want to
define the settings at the `hive` level and store each user's settings in a cluster.