Mesd\SettingsBundle\Model\SettingValidator
---------------

    

    


**Class name**: SettingValidator

**Namespace**: Mesd\SettingsBundle\Model









Properties
----------


**$setting** 



    private mixed $setting






**$settingNode** 



    private mixed $settingNode






**$valid** 



    private mixed $valid






**$validationMessage** 



    private mixed $validationMessage






Methods
-------


public **__construct**

    mixed Mesd\SettingsBundle\Model\SettingValidator::__construct(\Mesd\SettingsBundle\Model\Definition\SettingNode $settingNode, \Mesd\SettingsBundle\Model\Setting $setting)











**Arguments**:
**$settingNode** [Mesd\SettingsBundle\Model\Definition\SettingNode](Mesd-SettingsBundle-Model-Definition-SettingNode.md) 
**$setting** [Mesd\SettingsBundle\Model\Setting](Mesd-SettingsBundle-Model-Setting.md) 



public **sanitize**

    \Mesd\SettingsBundle\Model\Definition\SettingNode Mesd\SettingsBundle\Model\SettingValidator::sanitize()

Sanitize a setting

Clean the setting so that it matches it's SettingNode
definition.









public **validate**

    array Mesd\SettingsBundle\Model\SettingValidator::validate()

Validate a setting











public **sanitizeArray**

    boolean Mesd\SettingsBundle\Model\SettingValidator::sanitizeArray()

Sanitize an array setting











public **sanitizeBoolean**

    boolean Mesd\SettingsBundle\Model\SettingValidator::sanitizeBoolean()

Sanitize a boolean setting











public **sanitizeFloat**

    boolean Mesd\SettingsBundle\Model\SettingValidator::sanitizeFloat()

Sanitize a float setting











public **sanitizeString**

    boolean Mesd\SettingsBundle\Model\SettingValidator::sanitizeString()

Sanitize a string setting











protected **sanitizeDigits**

    boolean Mesd\SettingsBundle\Model\SettingValidator::sanitizeDigits()

Sanitize digits











protected **sanitizeLength**

    boolean Mesd\SettingsBundle\Model\SettingValidator::sanitizeLength()

Sanitize length











protected **sanitizePrecision**

    boolean Mesd\SettingsBundle\Model\SettingValidator::sanitizePrecision()

Sanitize precision











protected **sanitizeType**

    boolean Mesd\SettingsBundle\Model\SettingValidator::sanitizeType()

Sanitize data type











protected **validateArray**

    boolean Mesd\SettingsBundle\Model\SettingValidator::validateArray()

Validate an array setting











protected **validateBoolean**

    boolean Mesd\SettingsBundle\Model\SettingValidator::validateBoolean()

Validate a boolean setting











protected **validateFloat**

    boolean Mesd\SettingsBundle\Model\SettingValidator::validateFloat()

Validate a float setting











protected **validateInteger**

    boolean Mesd\SettingsBundle\Model\SettingValidator::validateInteger()

Validate a integer setting











protected **validateString**

    boolean Mesd\SettingsBundle\Model\SettingValidator::validateString()

Validate a string setting











protected **validateDigits**

    boolean Mesd\SettingsBundle\Model\SettingValidator::validateDigits()

Validate digits











protected **validateLength**

    boolean Mesd\SettingsBundle\Model\SettingValidator::validateLength()

Validate length











protected **validatePrecision**

    boolean Mesd\SettingsBundle\Model\SettingValidator::validatePrecision()

Validate precision











protected **validateType**

    boolean Mesd\SettingsBundle\Model\SettingValidator::validateType()

Validate data type










