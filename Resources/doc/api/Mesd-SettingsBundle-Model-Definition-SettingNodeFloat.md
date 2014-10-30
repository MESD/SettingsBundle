[Index](ApiIndex.md)


Mesd\SettingsBundle\Model\Definition\SettingNodeFloat
---------------


**Class name**: SettingNodeFloat

**Namespace**: Mesd\SettingsBundle\Model\Definition



**This class implements**: [Mesd\SettingsBundle\Model\Definition\SettingNodeTypeInterface](Mesd-SettingsBundle-Model-Definition-SettingNodeTypeInterface.md)



    Float setting node format data

    





Properties
----------


**$digits**

Number of digits in float.



    private integer $digits






**$precision**

Number of precision digits after decimal
point in float.



    private integer $precision






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

public **getDigits** (  )


Get digits








--

public **setDigits** ( integer $digits )


Set digits








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $digits | integer |  |

--

public **getPrecision** (  )


Get precision








--

public **setPrecision** ( integer $precision )


Set precision








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $precision | integer |  |

--
