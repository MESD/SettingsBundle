<?php

/**
 * This file is part of the MesdSettingsBundle.
 *
 * (c) MESD <appdev@mesd.k12.or.us>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Mesd\SettingsBundle\Model\Definition;

use Mesd\SettingsBundle\Model\Definition\SettingNodeTypeInterface;

/**
 * Array setting node format data
 *
 * @author David Cramblett <dcramble@mesd.k12.or.us>
 */
class SettingNodeArray implements SettingNodeTypeInterface
{

    /**
     * Prototype for array values
     *
     * @var integer
     */
    private $prototype;

    /**
     * Setting node for prototype
     *
     * @var SettingNodeTypeInterface
     */
    private $node;

    /**
     * Constructor
     *
     * @param array $nodeAttributes [optional]
     * @return self
     */
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

            $className = 'Mesd\SettingsBundle\Model\Definition\SettingNode' . ucwords($this->prototype);
            $this->node = new $className($nodeAttributes['prototype']);
        }
    }

    /**
     * Dump format data to array
     *
     * @return array
     */
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

    /**
     * Get array prototype
     *
     * @return string
     */
    public function getPrototype()
    {
        return $this->prototype;
    }

    /**
     * Set array prototype
     *
     * @param  string $prototype
     * @return self
     */
    public function setPrototype($prototype)
    {
        $this->prototype = $prototype;

        return $this;
    }

    /**
     * Get setting node
     *
     * @return SettingNodeTypeInterface
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Set digits
     *
     * @param  SettingNodeTypeInterface $node
     * @return self
     */
    public function setNode(SettingNodeTypeInterface $node)
    {
        $this->node = $node;

        return $this;
    }
}