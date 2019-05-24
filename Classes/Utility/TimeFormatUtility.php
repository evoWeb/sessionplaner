<?php

/*
 * This file is part of the package evoweb\sessionplaner.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Utility;

class TimeFormatUtility
{
    /**
     * @param int $value
     * @return string
     */
    public static function getFormattedTime($value)
    {
        $value = (int) $value;
        $hours = floor($value / 3600);
        $minutes = floor(($value / 60) % 60);
        $formatted = str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutes, 2, '0', STR_PAD_LEFT);

        return $formatted;
    }
}
