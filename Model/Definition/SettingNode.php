<?php

namespace Fc\SettingsBundle\Model\Definition;

class SettingNode
{

    private $default;
    private $description;
    private $format;
    private $name;
    private $type;


    public function __construct($nodeData = null)
    {
        if (null !== $nodeData && is_array($nodeData)) {
            $this->name    = $nodeData['nodeName'];
            $this->type    = $nodeData['nodeAttributes']['type'];
            $this->default = $nodeData['nodeAttributes']['default'];

            $className = 'Fc\SettingsBundle\Model\Definition\SettingNode' . ucwords($this->type);
            $this->format = new $className($nodeData['nodeAttributes']);
        }

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