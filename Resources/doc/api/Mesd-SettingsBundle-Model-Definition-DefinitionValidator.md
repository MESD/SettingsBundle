[API Index](ApiIndex.md)


Mesd\SettingsBundle\Model\Definition\DefinitionValidator
---------------


**Class name**: DefinitionValidator

**Namespace**: Mesd\SettingsBundle\Model\Definition







    Setting definition validator.

    





Properties
----------


**$definition**

Setting Definition Array



    private array $definition






Methods
-------


public **__construct** ( array $definition )


Constructor








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $definition | array |  |

--

public **validate** (  )


Validate setting definition or thorw Exception








--

private **validateStructure** (  )


Validate setting definition file structure








--

private **validateNodes** (  )


Validate setting definition nodes








--

private **validateNodeArray** ( string $nodeName, array $nodeAttributes, string $key )


Validate setting definition array node








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $nodeName | string |  |
| $nodeAttributes | array |  |
| $key | string |  |

--

private **validateNodeBoolean** ( string $nodeName, array $nodeAttributes, string $key )


Validate setting definition boolean node








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $nodeName | string |  |
| $nodeAttributes | array |  |
| $key | string |  |

--

private **validateNodeFloat** ( string $nodeName, array $nodeAttributes, string $key )


Validate setting definition float node








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $nodeName | string |  |
| $nodeAttributes | array |  |
| $key | string |  |

--

private **validateNodeInteger** ( string $nodeName, array $nodeAttributes, string $key )


Validate setting definition integer node








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $nodeName | string |  |
| $nodeAttributes | array |  |
| $key | string |  |

--

private **validateNodeString** ( string $nodeName, array $nodeAttributes, string $key )


Validate setting definition string node








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $nodeName | string |  |
| $nodeAttributes | array |  |
| $key | string |  |

--

[API Index](ApiIndex.md)
