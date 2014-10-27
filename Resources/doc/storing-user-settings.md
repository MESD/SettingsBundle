## Using the MesdSettingsBundle to store user settings

### Overview

The `MesdSettingsBundle` has been designed to store users settings just like it
stores application settings. This guide will walk you through the setup process
and give you code examples to use within your application.


###Step 1 - Create a new Hive

The first thing we need to do is define a new hive for the user settings. It's
important that we create the new hive using the 'definedAtHive' command line
option. We want the settings defined at the hive level because we'll want all
of the users to have the same settings. Only the setting values will be
different, or at least we'll have support for the values to be different. You
can give the hive whatever name you want, we'll use `User` for this example.
Additionally, we'll give the hive a description of `User Settings`.

``` bash
$ app/console mesd:setting:hive:create "User" "User Settings" --definedAtHive
```

###Step 2 - Define user settings

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
you would like. When your done choose 'e' to exit.

Here is the Setting Definition file for some example user settings:

```yaml
User:
    hive: User
    type: hive
    nodes:

        home-page:
            default: DemoBunde_dashBoard
            description: 'Home Page to load at login'
            type: string
            length: 50

        grid-page-size:
            default: 10
            description: 'Number of rows to display on grid'
            type: integer
            digits: 4

        display-avatar:
            default: true
            description: 'Display user image'
            type: boolean
```

###Step 3 - Update your application to create a new cluster for each user

At this point the setting system is ready to be used. You need to update your
applications code that creates new users and add some code to create a new
cluster for the users settings.

**Note:**
> For this example we'll assume your using the Symfony Security Component
> UserInterface. If your not, it's easy to use this bundle with any user
> interface, just determine the method you need to load your users unique
> username or userid.


```php

// Create a new user
$user = new User();
// ... Here is where your application logic for creating a new user lives

// Get SettingManager Service
$settingManger = $this->get('mesd_settings.setting_manager');

// Create a new settings cluster for this user
// $settingManger->createCluster($hiveName, $clusterName, $description = null);
$cluster = $settingManger->createCluster('user', $user->getUsername());
```

It's important that the first argument of `createCluster` be the hive name you
created earlier in step 1. The second argument should be a **unique** way of
identifying your user. Username is commonly a good option, or the database
unique ID field if your storing users in your applications database. The third
argument lets you set a description for the cluster, and is optional.