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
 * String setting node format data
 *
 * @author David Cramblett <dcramble@mesd.k12.or.us>
 */
class SettingNodeString
{

    /**
     * Maximum length of string
     *
     * @var integer
     */
    private $length;


    /**
     * Constructor
     *
     * @param array $nodeAttributes [optional]
     * @return self
     */
    public function __construct($nodeAttributes = null)
    {
        if (null !== $nodeAttributes && is_array($nodeAttributes)) {
            if(!isset($nodeAttributes['length'])) {
                throw new \Exception(
                    sprintf(
                        "SettingNodeString expects attribute 'length' to be defined in nodeAttributes"
                    )
                );
            }
            $this->length = $nodeAttributes['length'];
        }
    }

    /**
     * Dump format data to array
     *
     * @return array
     */
    public function dumpToArray()
    {
        return array('length' => $this->length);
    }

    /**
     * Get maximum length of string
     *
     * @return integer
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set maximum length of string
     *
     * @param  integer $length
     * @return self
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }
}