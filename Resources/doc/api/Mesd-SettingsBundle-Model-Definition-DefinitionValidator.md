Mesd\SettingsBundle\Model\Definition\DefinitionValidator
---------------


**Class name**: DefinitionValidator

**Namespace**: Mesd\SettingsBundle\Model\Definition







    

    





Properties
----------


**$definition**





    private  $definition






**$settingsManager**





    private  $settingsManager






Methods
-------


public **__construct** ( array $definition, $settingsManager )











**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $definition | array |  |
| $settingsManager | mixed |  |

--

public **validate** (  )











--

private **validateStructure** (  )











--

private **validateNodes** (  )











--

private **validateNodeArray** ( $nodeName, $nodeAttributes, $key )











**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $nodeName | mixed |  |
| $nodeAttributes | mixed |  |
| $key | mixed |  |

--

private **validateNodeBoolean** ( $nodeName, $nodeAttributes, $key )











**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $nodeName | mixed |  |
| $nodeAttributes | mixed |  |
| $key | mixed |  |

--

private **validateNodeFloat** ( $nodeName, $nodeAttributes, $key )











**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $nodeName | mixed |  |
| $nodeAttributes | mixed |  |
| $key | mixed |  |

--

private **validateNodeInteger** ( $nodeName, $nodeAttributes, $key )











**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $nodeName | mixed |  |
| $nodeAttributes | mixed |  |
| $key | mixed |  |

--

private **validateNodeString** ( $nodeName, $nodeAttributes, $key )











**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $nodeName | mixed |  |
| $nodeAttributes | mixed |  |
| $key | mixed |  |

--
