<?php

namespace Fc\SettingsBundle\Model\Definition;

class SettingNodeInteger
{

    private $digits;

    public function __construct($nodeAttributes = null)
    {
        if (null !== $nodeAttributes && is_array($nodeAttributes)) {
            if(!isset($nodeAttributes['digits'])) {
                throw new \Exception(
                    sprintf(
                        "SettingNodeInteger expects attribute 'digits' to be defined in nodeAttributes"
                    )
                );
            }
            $this->digits    = $nodeAttributes['digits'];
        }
    }

    public function dumpToArray()
    {
        return array('digits' => $this->digits);
    }

    public function getDigits()
    {
        return $this->digits;
    }

    public function setDigits($digits)
    {
        $this->digits = $digits;

        return $this;
    }
}