<?php

namespace Fc\SettingsBundle\Model\Definition;

class SettingNodeFloat
{

    private $digits;
    private $precision;


    public function __construct($nodeAttributes = null)
    {
        if (null !== $nodeAttributes && is_array($nodeAttributes)) {
            if(!isset($nodeAttributes['digits'])) {
                throw new \Exception(
                    sprintf(
                        "SettingNodeFloat expects attribute 'digits' to be defined in nodeAttributes"
                    )
                );
            }
            $this->digits    = $nodeAttributes['digits'];

            if(!isset($nodeAttributes['precision'])) {
                throw new \Exception(
                    sprintf(
                        "SettingNodeFloat expects attribute 'precision' to be defined in nodeAttributes"
                    )
                );
            }
            $this->precision = $nodeAttributes['precision'];
        }
    }

    public function dumpToArray()
    {
        return array(
            'digits'    => $this->digits,
            'precision' => $this->precision
        );
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