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

/**
 * Setting Node.
 *
 * @author David Cramblett <dcramble@mesd.k12.or.us>
 */
class SettingNode
{

    /**
     * Setting defualt value
     *
     * @var mixed
     */
    private $default;

    /**
     * Setting description
     *
     * @var string
     */
    private $description;

    /**
     * Setting format object
     *
     * @var SettingNode[Type]
     */
    private $format;

    /**
     * Setting name
     *
     * @var string
     */
    private $name;

    /**
     * Setting type
     *
     * @var string
     */
    private $type;


    /**
     * Constructor
     *
     * @param array $nodeData [optional]
     * @return self
     */
    public function __construct($nodeData = null)
    {
        if (null !== $nodeData && is_array($nodeData)) {
            $this->name    = $nodeData['nodeName'];
            $this->type    = $nodeData['nodeAttributes']['type'];

            if (array_key_exists('default', $nodeData['nodeAttributes'])) {
                $this->default = $nodeData['nodeAttributes']['default'];
            }

            if (array_key_exists('description', $nodeData['nodeAttributes'])) {
                $this->description = $nodeData['nodeAttributes']['description'];
            }

            $className = 'Mesd\SettingsBundle\Model\Definition\SettingNode' . ucwords($this->type);
            $this->format = new $className($nodeData['nodeAttributes']);
        }
    }

    /**
     * Get setting default value
     *
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Set setting default value
     *
     * @param  mixed $default
     * @return self
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Get setting description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set setting description
     *
     * @param  string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get setting format object
     *
     * @return SettingNode[Type]
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set setting default value
     *
     * @param  SettingNode[Type] $format
     * @return self
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get setting name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set setting name
     *
     * @param  string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get setting type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set setting type
     *
     * @param  string $type
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}