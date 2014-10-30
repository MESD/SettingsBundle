[Index](ApiIndex.md)


Mesd\SettingsBundle\Model\SettingValidator
---------------


**Class name**: SettingValidator

**Namespace**: Mesd\SettingsBundle\Model







    Validates settings to ensure they match the setting definition.

    





Properties
----------


**$setting**

The Setting



    private Setting $setting






**$settingNode**

The SettingNode



    private SettingNode $settingNode






**$valid**

Setting validation status



    private boolean $valid






**$validationMessage**

Setting validation error messages



    private string $validationMessage






Methods
-------


public **__construct** ( SettingNode $settingNode, Setting $setting )


Constructor








**Parameters**:

| Parameter | Type | Description |
|-----------|------|-------------|
| $settingNode | [SettingNode](Mesd-SettingsBundle-Model-Definition-SettingNode.md) |  |
| $setting | [Setting](Mesd-SettingsBundle-Model-Setting.md) |  |

--

public **sanitize** (  )


Clean the setting value so that it matches it&#039;s SettingNode
definition.








--

public **validate** (  )


Validate a setting








--

public **sanitizeArray** (  )


Sanitize an array setting








--

public **sanitizeBoolean** (  )


Sanitize a boolean setting








--

public **sanitizeFloat** (  )


Sanitize a float setting








--

public **sanitizeString** (  )


Sanitize a string setting








--

protected **sanitizeDigits** (  )


Sanitize digits








--

protected **sanitizeLength** (  )


Sanitize length








--

protected **sanitizePrecision** (  )


Sanitize precision








--

protected **sanitizeType** (  )


Sanitize data type








--

protected **validateArray** (  )


Validate an array setting








--

protected **validateBoolean** (  )


Validate a boolean setting








--

protected **validateFloat** (  )


Validate a float setting








--

protected **validateInteger** (  )


Validate a integer setting








--

protected **validateString** (  )


Validate a string setting








--

protected **validateDigits** (  )


Validate digits








--

protected **validateLength** (  )


Validate length








--

protected **validatePrecision** (  )


Validate precision








--

protected **validateType** (  )


Validate data type








--
