Mesd\SettingsBundle\Model\SettingValidator
===============






* Class name: SettingValidator
* Namespace: Mesd\SettingsBundle\Model





Properties
----------


### $setting

    private mixed $setting





* Visibility: **private**


### $settingNode

    private mixed $settingNode





* Visibility: **private**


### $valid

    private mixed $valid





* Visibility: **private**


### $validationMessage

    private mixed $validationMessage





* Visibility: **private**


Methods
-------


### __construct

    mixed Mesd\SettingsBundle\Model\SettingValidator::__construct(\Mesd\SettingsBundle\Model\Definition\SettingNode $settingNode, \Mesd\SettingsBundle\Model\Setting $setting)





* Visibility: **public**


#### Arguments
* $settingNode **[Mesd\SettingsBundle\Model\Definition\SettingNode](Mesd-SettingsBundle-Model-Definition-SettingNode.md)**
* $setting **[Mesd\SettingsBundle\Model\Setting](Mesd-SettingsBundle-Model-Setting.md)**



### sanitize

    \Mesd\SettingsBundle\Model\Definition\SettingNode Mesd\SettingsBundle\Model\SettingValidator::sanitize()

Sanitize a setting

Clean the setting so that it matches it's SettingNode
definition.

* Visibility: **public**




### validate

    array Mesd\SettingsBundle\Model\SettingValidator::validate()

Validate a setting



* Visibility: **public**




### sanitizeArray

    boolean Mesd\SettingsBundle\Model\SettingValidator::sanitizeArray()

Sanitize an array setting



* Visibility: **public**




### sanitizeBoolean

    boolean Mesd\SettingsBundle\Model\SettingValidator::sanitizeBoolean()

Sanitize a boolean setting



* Visibility: **public**




### sanitizeFloat

    boolean Mesd\SettingsBundle\Model\SettingValidator::sanitizeFloat()

Sanitize a float setting



* Visibility: **public**




### sanitizeString

    boolean Mesd\SettingsBundle\Model\SettingValidator::sanitizeString()

Sanitize a string setting



* Visibility: **public**




### sanitizeDigits

    boolean Mesd\SettingsBundle\Model\SettingValidator::sanitizeDigits()

Sanitize digits



* Visibility: **protected**




### sanitizeLength

    boolean Mesd\SettingsBundle\Model\SettingValidator::sanitizeLength()

Sanitize length



* Visibility: **protected**




### sanitizePrecision

    boolean Mesd\SettingsBundle\Model\SettingValidator::sanitizePrecision()

Sanitize precision



* Visibility: **protected**




### sanitizeType

    boolean Mesd\SettingsBundle\Model\SettingValidator::sanitizeType()

Sanitize data type



* Visibility: **protected**




### validateArray

    boolean Mesd\SettingsBundle\Model\SettingValidator::validateArray()

Validate an array setting



* Visibility: **protected**




### validateBoolean

    boolean Mesd\SettingsBundle\Model\SettingValidator::validateBoolean()

Validate a boolean setting



* Visibility: **protected**




### validateFloat

    boolean Mesd\SettingsBundle\Model\SettingValidator::validateFloat()

Validate a float setting



* Visibility: **protected**




### validateInteger

    boolean Mesd\SettingsBundle\Model\SettingValidator::validateInteger()

Validate a integer setting



* Visibility: **protected**




### validateString

    boolean Mesd\SettingsBundle\Model\SettingValidator::validateString()

Validate a string setting



* Visibility: **protected**




### validateDigits

    boolean Mesd\SettingsBundle\Model\SettingValidator::validateDigits()

Validate digits



* Visibility: **protected**




### validateLength

    boolean Mesd\SettingsBundle\Model\SettingValidator::validateLength()

Validate length



* Visibility: **protected**




### validatePrecision

    boolean Mesd\SettingsBundle\Model\SettingValidator::validatePrecision()

Validate precision



* Visibility: **protected**




### validateType

    boolean Mesd\SettingsBundle\Model\SettingValidator::validateType()

Validate data type



* Visibility: **protected**



