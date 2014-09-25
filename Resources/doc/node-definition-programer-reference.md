##Setting Node Definitions - Programmers Reference

###Overview

Creating setting node definitions is best done using the `symfony2` console
commands or by editing the yaml definition files in your text editor. However,
there may come a time that you need to create or update setting definitions from
within your code.


###Step 1 - Load an existing definition or create a new one

####Loading an existing definition:

``` php
$definitionManger = $this->get('fc_settings.definition_manager');

$definitionManger->loadFileByName('application-theme');

$settingDefinition = $definitionManger->getDefinition();
```

####Creating a new definition:

---
###Step 2 - Creating setting definition nodes:

**Warning:**

> The code examples below assume that *$settingDefinition* is an instance of the
> `SettingDefinition` object, of which you created with one of the methods above
> in step 1.

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
        'type'      => 'float',
        'digits'    => i,                    // int - Number of digits in float setting
        'precision' => i,                    // int - Number of digits after decimal in float setting
        'default'   => i.d,                  // float - Default value of float [optional]
        'description' => 'bar setting float' // string - Setting Description [optional]
    )
);

// Define a new setting node using array of node data
$settingNode = new \Fc\SettingsBundle\Model\Definition\SettingNode($nodeData);

// Add the new setting node to a definition you created or loaded previously
$settingDefinition->addSettingNode($settingNode);
```



