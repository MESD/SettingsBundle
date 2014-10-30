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
 * Boolean setting node format data
 *
 * @author David Cramblett <dcramble@mesd.k12.or.us>
 */
class SettingNodeBoolean implements SettingNodeTypeInterface
{

    /**
     * Constructor
     *
     * @param array $nodeAttributes [optional]
     * @return self
     */
    public function __construct($nodeAttributes = null)
    {
        if (null !== $nodeAttributes && is_array($nodeAttributes)) {
        }
    }

    /**
     * Dump format data to array
     *
     * @return array
     */
    public function dumpToArray()
    {
        return array();
    }

}