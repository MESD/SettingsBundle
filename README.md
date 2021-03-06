##Mesd/SettingsBundle

A `Symfony2` bundle for managing settings. The bundles intention is to manage application
or user settings, not `Symfony2` framework or bundle configuration items, the latter
already being well handled with Symfony's configuration component.

The SettingsBundle stores settings in a ORM supported database using two small tables.
Settings can be defined as a String, Integer, Float, Boolean, or Array. You define the
format for the setting, e.g. the max length, number of digits, or decimals. There is
also support for assigning default values. The settings available in your application
are defined using simple text yaml files, with like settings grouped together in a
structure called a cluster.

For more details please see the documentation.


###Documentation

The documentation is stored in the `Resources/doc` directory in this bundle:

[Read the Documentation](https://github.com/MESD/SettingsBundle/blob/master/Resources/doc/index.md)


###Installation

All the installation instructions are located in the documentation.


###License

This bundle is under the MIT license. See the complete license at:

[Resources/meta/LICENSE.md](https://github.com/MESD/SettingsBundle/blob/master/Resources/meta/LICENSE.md)


###Status

v1.0 Release Candidate #2 - March 25th, 2015
