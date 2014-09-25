##Setting Node Definition Programers Reference

###Overview

Creating setting node definitions is most easliy done using the symfony2 console
commands or by editing the yaml definition files in your text editor. However,
there may come a time that you need to create or update setting definitions from
within your code.


###Step1 - Load an exisiting or create a new setting definition

####Loading an exisiting definition:

####Createing a new definition:


###Step 2 - Createing setting definition nodes:

####Integder Node:

``` php
    $nodeData = array (
        'nodeName' => 'foo',
        'nodeAttributes' => array (
            'type'    => 'integer',
            'digits'  => **n**,       // int - Number of digits in integer setting
            'default' => **n**,       // int - Defualt value of integer setting [optional]
        )
    );

    $settingNode = new \Fc\SettingsBundle\Model\Definition\SettingNode($nodeData);
```