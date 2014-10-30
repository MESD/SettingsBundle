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
 * Integer setting node format data
 *
 * @author David Cramblett <dcramble@mesd.k12.or.us>
 */
class SettingNodeInteger
{

    /**
     * Number of digits in integer
     *
     * @var integer
     */
    private $digits;


    /**
     * Constructor
     *
     * @param array $nodeAttributes [optional]
     * @return self
     */
    public function __construct($nodeAttributes = null)
    {
        if (null !== $nodeAttributes && is_array($nodeAttributes)) {
            if(!isset($nodeAttributes['digits'])) {
                throw new \Exception(
                    sprintf(
                        "SettingNodeInteger expects attribute 'digits' to be defined in nodeAttributes"
                    )
                );
            }
            $this->digits    = $nodeAttributes['digits'];
        }
    }

    /**
     * Dump format data to array
     *
     * @return array
     */
    public function dumpToArray()
    {
        return array('digits' => $this->digits);
    }

    /**
     * Get digits
     *
     * @return integer
     */
    public function getDigits()
    {
        return $this->digits;
    }

    /**
     * Set digits
     *
     * @param  integer $digits
     * @return self
     */
    public function setDigits($digits)
    {
        $this->digits = $digits;

        return $this;
    }
}