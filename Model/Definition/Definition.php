<?php

namespace Fc\SettingsBundle\Model\Definition;


class Definition {

    private $hive;
    private $cluster;
    private $setting;


    public function __construct()
    {
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


    public function getValue()
    {
        return $this->value;
    }


    public function setType($value)
    {
        $this->value = $value;

        return $this;
    }

}