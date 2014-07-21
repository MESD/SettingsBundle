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


###Create a `hive`:

Since hives are application wide, you may only need a few or even a single `hive`.

