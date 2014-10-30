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
 * Float setting node format data
 *
 * @author David Cramblett <dcramble@mesd.k12.or.us>
 */
class SettingNodeFloat
{

    /**
     * Number of digits in float.
     *
     * @var integer
     */
    private $digits;

    /**
     * Number of precision digits after decimal
     * point in float.
     *
     * @var integer
     */
    private $precision;


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
                        "SettingNodeFloat expects attribute 'digits' to be defined in nodeAttributes"
                    )
                );
            }
            $this->digits    = $nodeAttributes['digits'];

            if(!isset($nodeAttributes['precision'])) {
                throw new \Exception(
                    sprintf(
                        "SettingNodeFloat expects attribute 'precision' to be defined in nodeAttributes"
                    )
                );
            }
            $this->precision = $nodeAttributes['precision'];
        }
    }

    /**
     * Dump format data to array
     *
     * @return array
     */
    public function dumpToArray()
    {
        return array(
            'digits'    => $this->digits,
            'precision' => $this->precision
        );
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

    /**
     * Get precision
     *
     * @return integer
     */
        public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * Set precision
     *
     * @param  integer $precision
     * @return self
     */
    public function setPrecision($precision)
    {
        $this->precision = $precision;

        return $this;
    }
}