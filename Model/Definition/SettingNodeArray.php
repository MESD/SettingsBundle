<?php

namespace Fc\SettingsBundle\Model\Definition;

class SettingNodeArray
{

    private $prototype;
    private $node;


    public function __construct($nodeAttributes = null)
    {
        if (null !== $nodeAttributes && is_array($nodeAttributes)) {
            if(!isset($nodeAttributes['prototype'])) {
                throw new \Exception(
                    sprintf(
                        "SettingNodeArray expects attribute 'prototype' to be defined in nodeAttributes"
                    )
                );
            }
            if(!isset($nodeAttributes['prototype']['type'])) {
                throw new \Exception(
                    sprintf(
                        "SettingNodeArray expects attribute 'type' to be defined in nodeAttributes[prototype]"
                    )
                );
            }
            $this->prototype = $nodeAttributes['prototype']['type'];

            $className = 'Fc\SettingsBundle\Model\Definition\SettingNode' . ucwords($this->prototype);
            $this->node = new $className($nodeAttributes['prototype']);
        }
    }

    public function dumpToArray()
    {
        $prototype = array(
            'prototype' => array(
                'type'  => $this->prototype
            )
        );

        foreach ($this->node->dumpToArray() as $key => $val) {
            $prototype['prototype'][$key] = $val;
        }

        return $prototype;
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