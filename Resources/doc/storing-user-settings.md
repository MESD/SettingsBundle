## Using the MesdSettingsBundle to store user settings

### Overview

The `MesdSettingsBundle` has been designed to store users settings just like it
stores application settings. This guide will walk you through the setup process
and give you code examples to use within your application.


###Step 1 - Create a new Hive

The first thing we need to do is define a new hive for our user settings. It's
important that we create the new hive using the 'definedAtHive' command line
option. We want the settings defined at the hive level because we'll want all
of our users to have the same settings. Only the setting values will be
different, or at least we'll have support for the values to be different. You
can give the hive whatever name you want, we'll use `User` for this example.
Additionally, we'll give the hive a description of `User Settings`.

``` bash
$ app/console mesd:setting:hive:create "User" "User Settings" --definedAtHive
```

###Step 2 - Define some user settings

Once the new hive is created, we can define some settings. You don't have to
define every setting right away, settings can easily be added as your
application demands them.

``` bash
$ app/console mesd:setting:setting:define "User"
```

The define settings command will inform you that it could not locate a
'user.yml' setting definition file. Answer yes at the prompt to have one
created for you.

Next you will be asked where to store the settings definition file. Choose
your desired location from the menu.

Now the define setting command will allow you to define as many settings as
you would like. Wen your done choose 'e' to exit.