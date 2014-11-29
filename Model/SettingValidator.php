<?php

/**
 * This file is part of the MesdSettingsBundle.
 *
 * (c) MESD <appdev@mesd.k12.or.us>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Mesd\SettingsBundle\Model;

use Mesd\SettingsBundle\Model\Definition\SettingNode;
use Mesd\SettingsBundle\Model\Setting;

/**
 * Validates settings to ensure they match the setting definition.
 *
 * @author David Cramblett <dcramble@mesd.k12.or.us>
 */
class SettingValidator {

    /**
     * The Setting
     *
     * @var Setting
     */
    private $setting;

    /**
     * The SettingNode
     *
     * @var SettingNode
     */
    private $settingNode;

    /**
     * Setting validation status
     *
     * @var boolean
     */
    private $valid;

    /**
     * Setting validation error messages
     *
     * @var string
     */
    private $validationMessage;


    /**
     * Constructor
     *
     * @param SettingNode $settingNode
     * @param Setting $setting
     * @return self
     */
    public function __construct(SettingNode $settingNode, Setting $setting)
    {
         $this->setting     = $setting;
         $this->settingNode = $settingNode;
    }


    /**
     * Clean the setting value so that it matches it's SettingNode
     * definition.
     *
     * @return SettingNode
     */
    public function sanitize()
    {
        $sanitationMethod = 'sanitize' . ucwords($this->settingNode->getType());
        $this->$sanitationMethod();

        return $this->setting;
    }


     /**
     * Validate a setting
     *
     * @return array (boolean $valid, string $validationMessage)
     */
    public function validate()
    {
        $this->valid = true;

        $validationMethod = 'validate' . ucwords($this->settingNode->getType());
        $this->$validationMethod();

        return array(
            'valid'             => $this->valid,
            'validationMessage' => $this->validationMessage
        );
    }


    /**
     * Sanitize an array setting
     *
     * @return boolean
     */
    public function sanitizeArray()
    {
        $this->sanitizeType();

        return true;
    }


    /**
     * Sanitize a boolean setting
     *
     * @return boolean
     */
    public function sanitizeBoolean()
    {
        $this->sanitizeType();

        return true;
    }


    /**
     * Sanitize a float setting
     *
     * @return boolean
     */
    public function sanitizeFloat()
    {
        $this->sanitizeType();
        $this->sanitizeDigits();
        $this->sanitizePrecision();

        return true;
    }


    /**
     * Sanitize a integer setting
     *
     * @return boolean
     */
    public function sanitizeInteger()
    {
        $this->sanitizeType();
        $this->sanitizeDigits();

        return true;
    }


    /**
     * Sanitize a string setting
     *
     * @return boolean
     */
    public function sanitizeString()
    {
        $this->sanitizeType();
        $this->sanitizeLength();

        return true;
    }


    /**
     * Sanitize digits
     *
     * @return boolean
     */
    protected function sanitizeDigits()
    {
        //Validate digits
        if (false === $this->validateDigits()) {
            $this->setting->setValue(
                $this->settingNode->getDefault()
            );
        }

        return true;
    }


    /**
     * Sanitize length
     *
     * @return boolean
     */
    protected function sanitizeLength()
    {
        //Validate length
        if (false === $this->validateLength()) {
            $this->setting->setValue(
                $this->settingNode->getDefault()
            );
        }

        return true;
    }


    /**
     * Sanitize precision
     *
     * @return boolean
     */
    protected function sanitizePrecision()
    {
        //Validate precision
        if (false === $this->validatePrecision()) {
            $this->setting->setValue(
                $this->settingNode->getDefault()
            );
        }

        return true;
    }


    /**
     * Sanitize data type
     *
     * @return boolean
     */
    protected function sanitizeType()
    {
        // Validate type
        if (false === $this->validateType()) {
            $settingType = getType($this->setting->getValue());
            $settingType = ('double' == $settingType) ? 'float': $settingType;

            $settingNodeType = $this->settingNode->getType();

            if ('string' == $settingNodeType && 'array' != $settingType) {
                $this->setting->setValue(
                    strval($this->setting->getValue())
                );
            }
            else {
                $this->setting->setValue(
                    $this->settingNode->getDefault()
                );
            }
        }

        return true;
    }


    /**
     * Validate an array setting
     *
     * @return boolean
     */
    protected function validateArray()
    {
        $valid = true;

        $valid = (false === $this->validateType()) ? false : $valid;

        return $valid;
    }


    /**
     * Validate a boolean setting
     *
     * @return boolean
     */
    protected function validateBoolean()
    {
        $valid = true;

        $valid = (false === $this->validateType()) ? false : $valid;

        return $valid;
    }


    /**
     * Validate a float setting
     *
     * @return boolean
     */
    protected function validateFloat()
    {
        $valid = true;

        $valid = (false === $this->validateType()) ? false : $valid;

        if ($valid) {
            $valid = (false === $this->validateDigits()) ? false : $valid;
            $valid = (false === $this->validatePrecision()) ? false : $valid;
        }

        return $valid;
    }


    /**
     * Validate a integer setting
     *
     * @return boolean
     */
    protected function validateInteger()
    {
        $valid = true;

        $valid = (false === $this->validateType()) ? false : $valid;

        if ($valid) {
            $valid = (false === $this->validateDigits()) ? false : $valid;
        }

        return $valid;
    }


    /**
     * Validate a string setting
     *
     * @return boolean
     */
    protected function validateString()
    {
        $valid = true;

        $valid = (false === $this->validateType()) ? false : $valid;

        if ($valid) {
            $valid = (false === $this->validateLength()) ? false : $valid;
        }

        return $valid;
    }


    /**
     * Validate digits
     *
     * @return boolean
     */
    protected function validateDigits()
    {
        $settingDigits     = strlen(preg_split('/\./', $this->setting->getValue(), 2)[0]);
        $settingNodeDigits = $this->settingNode->getFormat()->getDigits();

        if($settingDigits > $settingNodeDigits) {
            $this->valid = false;
            $this->validationMessage .= sprintf(
                "  Expected max digits '%s', but found '%s' digits \n",
                $settingNodeDigits,
                $settingDigits
            );

            return false;
        }

        return true;
    }


    /**
     * Validate length
     *
     * @return boolean
     */
    protected function validateLength()
    {
        $settingLength     = strlen($this->setting->getValue());
        $settingNodeLength = $this->settingNode->getFormat()->getLength();

        if($settingLength > $settingNodeLength) {
            $this->valid = false;
            $this->validationMessage .= sprintf(
                "  Expected max length '%s', but found string length '%s' \n",
                $settingNodeLength,
                $settingLength
            );

            return false;
        }

        return true;
    }


    /**
     * Validate precision
     *
     * @return boolean
     */
    protected function validatePrecision()
    {
        $settingPrecision = 0;
        if (array_key_exists(1, preg_split('/\./', $this->setting->getValue(), 2))) {
            $settingPrecision = strlen(preg_split('/\./', $this->setting->getValue(), 2)[1]);
        }

        $settingNodePrecision = $this->settingNode->getFormat()->getPrecision();

        if($settingPrecision > $settingNodePrecision) {
            $this->valid = false;
            $this->validationMessage .= sprintf(
                "  Expected max precision digits '%s', but found '%s' precision digits \n",
                $settingNodePrecision,
                $settingPrecision
            );

            return false;
        }

        return true;
    }


    /**
     * Validate data type
     *
     * @return boolean
     */
    protected function validateType()
    {
        $settingType = getType($this->setting->getValue());
        $settingType = ('double' == $settingType) ? 'float': $settingType;

        $settingNodeType = $this->settingNode->getType();

        // Allow Integer setting values for node types of Float
        if ('float' == $settingNodeType && 'integer' == $settingType) {
            $settingType = 'float';
        }

        if($settingType != $settingNodeType) {
            $this->valid = false;
            $this->validationMessage .= sprintf(
                "  Expected Type '%s', but found type '%s'.\n",
                $settingNodeType,
                $settingType
            );

            return false;
        }

        return true;
    }

}