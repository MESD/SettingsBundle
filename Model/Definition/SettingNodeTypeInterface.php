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
 * Setting node type interface
 *
 * @author David Cramblett <dcramble@mesd.k12.or.us>
 */
interface SettingNodeTypeInterface
{

    /**
     * Dump format data to array.
     *
     * @return array
     */
    public function dumpToArray();

}