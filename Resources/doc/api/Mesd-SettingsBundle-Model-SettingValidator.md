Mesd\SettingsBundle\Model\SettingValidator
---------------

    

    


**Class name**: SettingValidator

**Namespace**: Mesd\SettingsBundle\Model









Properties
----------


**$setting**  |  



    private mixed $setting






**$settingNode**  |  



    private mixed $settingNode






**$valid**  |  



    private mixed $valid






**$validationMessage**  |  



    private mixed $validationMessage






Methods
-------


public **__construct** ( \Mesd\SettingsBundle\Model\Definition\SettingNode $settingNode, \Mesd\SettingsBundle\Model\Setting $setting )











**Parameters**:

> $settingNode [Mesd\SettingsBundle\Model\Definition\SettingNode](Mesd-SettingsBundle-Model-Definition-SettingNode.md) 
> $setting [Mesd\SettingsBundle\Model\Setting](Mesd-SettingsBundle-Model-Setting.md) 


--


public **sanitize** (  )


Sanitize a setting

Clean the setting so that it matches it&#039;s SettingNode
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

