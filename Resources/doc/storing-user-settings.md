## Using the MesdSettingsBundle to store user settings

### Overview

The `MesdSettingsBundle` has been designed to store users settings just like it
stores application settings. This guide will walk you through the setup process
and give you code examples to use within your application.


###Step 1 - Create a new Hive

The first thing we need to do is define a new hive for our user settings. It's
important that we create the new hive using the --definedAtHive command line
option. We want the settings defined at the hive level because we'll want all
of our users to have the same settings. Only the setting values will be
different, or at least we'll have support for the values to be different. You
can call the hive what ever you want, we'll use `User` for our example.
Additionally, we'll give our hive a description of `User Settings`.

``` bash
$ app/console mesd:setting:hive:create "User" "User Settings" --definedAtHive
```

####Option A - Loading an existing definition:

