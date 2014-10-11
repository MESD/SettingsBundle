<?php

namespace Fc\SettingsBundle\Model;


class Setting {

    private $name;
    private $value;


    public function __construct()
    {
    }


    public function getName()
    {
        return $this->name;
    }


    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    public function getValue()
    {
        return $this->value;
    }


    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

}