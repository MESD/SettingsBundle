##Mesd/SettingsBundle

A Symfony2 bundle for managing settings. The bundles intention is to manage application
or user settings, not Symfony2 framework or bundle configuration items, the latter
already being well handled within symfony.

The SettingsBundle stores settings in a ORM supported database, using only two small
tables. Settings can be defined as String, Integer, Float, Boolean, or Array. You can
also define the max length, number digits, or decimals in each setting (depending on
type). There is also support for assigning default values. The settings available in
your application are defined using simple text yaml files. Like type settings can be
grouped together.

For more details, please see the documentation.


###Documentation

The documentation is stored in the `Resources/doc` directory in this bundle:

[Read the Documentationn](https://github.com/MESD/SettingsBundle/blob/master/Resources/doc/index.md)


###Installation

All the installation instructions are located in the documentation.


###License

This bundle is under the MIT license. See the complete license at:

[Resources/meta/LICENSE.md](https://github.com/MESD/SettingsBundle/blob/master/Resources/meta/LICENSE.md)
