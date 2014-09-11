<?php

namespace Fc\SettingsBundle\Model\Definition;


abstract class SettingNode
{

    private $default;
    private $description;
    private $name;
    private $type;


    public function __construct()
    {
    }


    public function getDefault()
    {
        return $this->default;
    }


    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }


    public function getDescription()
    {
        return $this->description;
    }


    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }


    public function getFormat()
    {
        return $this->format;
    }


    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
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


    public function getType()
    {
        return $this->type;
    }


    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}