<?php

namespace Fc\SettingsBundle\Model\Definition;

class SettingNodeFloat
{

    private $digits;
    private $precision;


    public function __construct($nodeAttributes = null)
    {
        if (null !== $nodeAttributes && is_array($nodeAttributes)) {
            $this->digits    = $nodeAttributes['digits'];
            $this->precision = $nodeAttributes['precision'];
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


        public function getPrecision()
    {
        return $this->precision;
    }


    public function setPrecision($precision)
    {
        $this->precision = $precision;

        return $this;
    }

}