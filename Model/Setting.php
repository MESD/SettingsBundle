<?php

namespace Fc\SettingsBundle\Model;


class Setting {

    private $name;
    private $value;
    private $definition;


    public function __construct($definition = null)
    {
        $this->definition = $definition;
    }


    public function getDefinition()
    {
        if (null === $definition) {
            throw new \Exception('The definition was not requested and therefore is not avialable');
        }

        return $this->definition;
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