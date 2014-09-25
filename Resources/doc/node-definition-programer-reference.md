##Setting Node Definition Programmers Reference

###Overview

Creating setting node definitions is most easily done using the `symfony2` console
commands or by editing the yaml definition files in your text editor. However,
there may come a time that you need to create or update setting definitions from
within your code.


###Step1 - Load an existing or create a new setting definition

####Loading an existing definition:

``` php
    $definitionManger = $this->get('fc_settings.definition_manager');

    $definitionManger->loadFileByName('application-theme');

    $settingDefinition = $definitionManger->getDefinition();
```

####Creating a new definition:

###Step 2 - Creating setting definition nodes:

####Integer Node:

``` php
    // Define array of setting node data
    $nodeData = array (
        'nodeName' => 'foo',
        'nodeAttributes' => array (
            'type'    => 'integer',
            'digits'  => i,         // int - Number of digits in integer setting
            'default' => i,         // int - Default value of integer setting [optional]
        )
    );

    // Define a new setting node using array of node data
    $settingNode = new \Fc\SettingsBundle\Model\Definition\SettingNode($nodeData);

    // Add the new setting node to a definition you created or loaded previously
    $settingDefinition->addSettingNode($settingNode);
```