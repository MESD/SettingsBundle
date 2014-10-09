##Setting Definitions - Programmers Reference

###Overview

Creating setting node definitions is best done using the `symfony2` console
commands or by editing the yaml definition files in your text editor. However,
there may come a time that you need to create or update setting definitions from
within your code dynamically.


###Step 1 - Load an existing definition or create a new one

####Option A - Loading an existing definition:

``` php
// Get Definition Manager Service
$definitionManger = $this->get('fc_settings.definition_manager');

// Load existing definition by hive and cluster ($hiveName, $clusterName)
$settingDefinition = $definitionManger->loadFile('application', 'theme');
```

**Note:**

> When loading an existing definition, the cluster is not needed when settings
> are defined at the hive. In this case you can just leave the `clusterName`
> parameter off of the `loadFile` method.

####Option B - Creating a new definition:

``` php
// Create a new SettingDefiniiton instance
$settingDefinition = new \Fc\SettingsBundle\Model\Definition\SettingDefinition();

// Set the definition type (cluster or hive)
$settingDefinition->setType('cluster');

// Set the definition key (cluster name on cluster type, hive name on hive type )
$settingDefinition->setKey('theme');

// Set the definition hive
$settingDefinition->setHive('application');

```

###Step 2 - Creating setting definition nodes:

**Note:**

> The code examples below assume that *$settingDefinition* is an instance of the
> `SettingDefinition` object, of which you created with one of the options above
> in step 1.

**Warning:**

> If you load an existing setting definition and define a new setting node,
> that has the same name as an existing setting node, you will overwrite the
> existing node when you save the definition.

####Integer Node:

``` php
// Define array containing setting node data
$nodeData = array (
    'nodeName' => 'foo',
    'nodeAttributes' => array (
        'type'        => 'integer',
        'digits'      => i,                    // int - Number of digits in integer
        'default'     => i,                    // int - Default value of integer [optional]
        'description' => 'foo setting integer' // string - Setting Description [optional]
    )
);

// Define a new setting node using array of node data
$settingNode = new \Fc\SettingsBundle\Model\Definition\SettingNode($nodeData);

// Add the new setting node to a definition you created or loaded previously
$settingDefinition->addSettingNode($settingNode);
```

####Float Node:

``` php
// Define array containing setting node data
$nodeData = array (
    'nodeName' => 'bar',
    'nodeAttributes' => array (
        'type'        => 'float',
        'digits'      => i,                  // int - Number of digits in float setting
        'precision'   => i,                  // int - Number of digits after decimal in float setting
        'default'     => i.d,                // float - Default value of float [optional]
        'description' => 'bar setting float' // string - Setting Description [optional]
    )
);

// Define a new setting node using array of node data
$settingNode = new \Fc\SettingsBundle\Model\Definition\SettingNode($nodeData);

// Add the new setting node to a definition you created or loaded previously
$settingDefinition->addSettingNode($settingNode);
```

####String Node:

``` php
// Define array containing setting node data
$nodeData = array (
    'nodeName' => 'baz',
    'nodeAttributes' => array (
        'type'        => 'string',
        'length'      => i,                   // int - Max Length of string setting
        'default'     => 'baz',               // string - Default value of string [optional]
        'description' => 'baz setting string' // string - Setting Description [optional]
    )
);

// Define a new setting node using array of node data
$settingNode = new \Fc\SettingsBundle\Model\Definition\SettingNode($nodeData);

// Add the new setting node to a definition you created or loaded previously
$settingDefinition->addSettingNode($settingNode);
```

####Boolean Node:

``` php
// Define array containing setting node data
$nodeData = array (
    'nodeName' => 'buz',
    'nodeAttributes' => array (
        'type'        => 'boolean',
        'default'     => false,                // boolean - Default value of boolean [optional]
        'description' => 'buz setting boolean' // string - Setting Description [optional]
    )
);

// Define a new setting node using array of node data
$settingNode = new \Fc\SettingsBundle\Model\Definition\SettingNode($nodeData);

// Add the new setting node to a definition you created or loaded previously
$settingDefinition->addSettingNode($settingNode);
```


####Array Node:

Array nodes hold an array of values for each setting. Each array node needs
a `prototype` definition which defines the type of data contained within the
array. The prototype must be one of the base types (integer, float, string,
or boolean) and the prototype definition must contain all of the attributes
the base type requires. i.e. String type requires a 'length' attribute.

#####Array Node (Integer prototype example):

``` php
// Define array containing setting node data
$nodeData = array (
    'nodeName' => 'fuz',
    'nodeAttributes' => array (
        'type'        => 'array',
        'prototype' => array(           // array - Prototype definition
            'type'   => 'integer',
            'digits' => i               // int - Number of digits in integer prototype
        ),
        'default' => array(             // array - Array of default int values [optional]
            0 => 25,
            1 => 30,
            2 => 35
        ),
        'description' => 'fuz setting array' // string - Setting Description [optional]
    )
);

// Define a new setting node using array of node data
$settingNode = new \Fc\SettingsBundle\Model\Definition\SettingNode($nodeData);

// Add the new setting node to a definition you created or loaded previously
$settingDefinition->addSettingNode($settingNode);
```

#####Array Node (String prototype example):

``` php
// Define array containing setting node data
$nodeData = array (
    'nodeName' => 'fuz',
    'nodeAttributes' => array (
        'type'        => 'array',
        'prototype' => array(           // array - Prototype definition
            'type'   => 'string',
            'length' => i               // int - Max length of string prototype
        ),
        'default' => array(             // array - Array of default string values [optional]
            0 => 'foo',
            1 => 'bar',
            2 => 'baz'
        ),
        'description' => 'fuz setting array' // string - Setting Description [optional]
    )
);

// Define a new setting node using array of node data
$settingNode = new \Fc\SettingsBundle\Model\Definition\SettingNode($nodeData);

// Add the new setting node to a definition you created or loaded previously
$settingDefinition->addSettingNode($settingNode);
```

###Step 3 - Save the setting definition:

``` php
// Get Definition Manager Service
$definitionManger = $this->get('fc_settings.definition_manager');

// Save definition to file
$definitionManger->saveFile($settingDefinition);
```