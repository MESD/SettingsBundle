<?php

namespace Fc\SettingsBundle\Model;

use Fc\SettingsBundle\Model\Definition\SettingNode;
use Fc\SettingsBundle\Model\Setting;

class SettingValidator {

    private $setting;
    private $settingNode;
    private $valid;
    private $validationMessage;



    public function __construct(SettingNode $settingNode, Setting $setting)
    {
         $this->setting     = $setting;
         $this->settingNode = $settingNode;
    }


    /**
     * Sanitize a setting
     *
     * Clean the setting so that it matches it's SettingNode
     * definition.
     *
     * @return SettingNode
     */
    public function sanitize()
    {

        return $this->setting;
    }


    /**
     * Validate a setting
     *
     * @return array (valid, validationMessage)
     */
    public function validate()
    {
        $validationMethod = 'validate' . ucwords($this->settingNode->getType());

        return $this->$validationMethod();
    }


    /**
     * Validate a string setting
     *
     * @return array (valid, validationMessage)
     */
    protected function validateString()
    {
        $this->valid = true;

        // Check type
        if('string' != getType($this->setting->getValue())) {
            $this->valid = false;
            $this->validationMessage = sprintf(
                "  Expected Type 'string', but found type '%s'.\n",
                getType($this->setting->getValue())
            );
        }

        // Check length
        if(strlen($this->setting->getValue()) > $this->settingNode->getFormat()->getLength()) {
            $this->valid = false;
            $this->validationMessage .= sprintf(
                "  Expected max length '%s', but found string length '%s' \n",
                $this->settingNode->getFormat()->getLength(),
                strlen($this->setting->getValue())
            );
        }

        return array(
            'valid'             => $this->valid,
            'validationMessage' => $this->validationMessage
        );
    }

}