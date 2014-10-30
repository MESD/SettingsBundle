[API Index](ApiIndex.md)


Mesd\SettingsBundle\Model\Definition\SettingNodeArray
---------------


**Class name**: SettingNodeArray

**Namespace**: Mesd\SettingsBundle\Model\Definition



**This class implements**: [Mesd\SettingsBundle\Model\Definition\SettingNodeTypeInterface](Mesd-SettingsBundle-Model-Definition-SettingNodeTypeInterface.md)



    Array setting node format data

    





Properties
----------


**$prototype**

Prototype for array values



    private integer $prototype






**$node**

Setting node for prototype



    private SettingNodeTypeInterface $node






Methods
-------


public **__construct** ( array $nodeAttributes )


Constructor








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $nodeAttributes | array | &lt;p&gt;[optional]&lt;/p&gt; |

--

public **dumpToArray** (  )


Dump format data to array.








--

public **getPrototype** (  )


Get array prototype








--

public **setPrototype** ( string $prototype )


Set array prototype








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $prototype | string |  |

--

public **getNode** (  )


Get setting node








--

public **setNode** ( SettingNodeTypeInterface $node )


Set digits








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $node | [SettingNodeTypeInterface](Mesd-SettingsBundle-Model-Definition-SettingNodeTypeInterface.md) |  |

--

[API Index](ApiIndex.md)
