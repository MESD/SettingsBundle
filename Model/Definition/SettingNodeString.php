<?php

namespace Fc\SettingsBundle\Model\Definition;

class SettingNodeString
{

    private $length;


    public function __construct($nodeAttributes = null)
    {
        if (null !== $nodeAttributes && is_array($nodeAttributes)) {
            $this->length = $nodeAttributes['length'];
        }
    }


    public function getLength()
    {
        return $this->length;
    }


    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

}