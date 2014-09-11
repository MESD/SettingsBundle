<?php

namespace Fc\SettingsBundle\Model\Definition;

class SettingNodeInteger
{

    private $digits;


    public function __construct($nodeAttributes = null)
    {
        if (null !== $nodeAttributes && is_array($nodeAttributes)) {
            $this->digits    = $nodeAttributes['digits'];
        }
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