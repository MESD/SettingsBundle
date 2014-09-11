<?php

namespace Fc\SettingsBundle\Model\Definition;

class SettingNodeArray
{

    private $prototype;
    private $node;


    public function __construct($nodeAttributes = null)
    {
        if (null !== $nodeAttributes && is_array($nodeAttributes)) {
            $this->prototype = $nodeAttributes['prototype']['type'];

            $className = 'Fc\SettingsBundle\Model\Definition\SettingNode' . ucwords($this->prototype);
            $this->node = new $className($nodeAttributes['prototype']);
        }
    }


    public function getPrototype()
    {
        return $this->prototype;
    }


    public function setPrototype($prototype)
    {
        $this->prototype = $prototype;

        return $this;
    }


    public function getNode()
    {
        return $this->node;
    }


    public function setNode($node)
    {
        $this->node = $node;

        return $this;
    }
}