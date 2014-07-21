##Install Fc/SettingsBundle

###Dependencies:

    "symfony/symfony": "2.3.*",
    "doctrine/orm": "~2.3"

###Install with composer:

    tbw


##Using Fc/SettingsBundle

###Understanding the terminology:

Like type settings are stored in a group called a `cluster`. Each `cluster` is attached
to a `hive`. You can create as many hives and clusters as you need. You should think of
a `hive` as an application wide classification, and a `cluster` as sub-classification.


###Create a new Hive:

Since hives are application wide, you may only need a few or even a single `hive`. If
your application is rather large and can be broken down into sub-applications, you
might create a `hive` for each.


###Create a new Cluster:

Clusters are used to group like settings. For example if you had 5 settings that
controlled the theme of your application, you might create a `theme cluster`.


###Create a new Setting:

Each `setting` has four descriptors: `name`, `description`, `type`, and `format`.