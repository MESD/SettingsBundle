Mesd\SettingsBundle\Model\Definition\DefinitionValidator
---------------

    

    


**Class name**: DefinitionValidator

**Namespace**: Mesd\SettingsBundle\Model\Definition









Properties
----------


**$definition**  |  



    private mixed $definition






**$settingsManager**  |  



    private mixed $settingsManager






Methods
-------


public **__construct** ( array $definition, $settingsManager )


    








**Arguments**:

$definition array 
$settingsManager mixed 


--


public **validate** (  )


    









--


private **validateStructure** (  )


    









--


private **validateNodes** (  )


    









--


private **validateNodeArray** ( $nodeName, $nodeAttributes, $key )


    








**Arguments**:

$nodeName mixed 
$nodeAttributes mixed 
$key mixed 


--


private **validateNodeBoolean** ( $nodeName, $nodeAttributes, $key )


    








**Arguments**:

$nodeName mixed 
$nodeAttributes mixed 
$key mixed 


--


private **validateNodeFloat** ( $nodeName, $nodeAttributes, $key )


    








**Arguments**:

$nodeName mixed 
$nodeAttributes mixed 
$key mixed 


--


private **validateNodeInteger** ( $nodeName, $nodeAttributes, $key )


    








**Arguments**:

$nodeName mixed 
$nodeAttributes mixed 
$key mixed 


--


private **validateNodeString** ( $nodeName, $nodeAttributes, $key )


    








**Arguments**:

$nodeName mixed 
$nodeAttributes mixed 
$key mixed 


--

