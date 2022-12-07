<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Utility;

class TimeFormatUtility
{
    public static function getFormattedTime(int $value): string
    {
        $value = (int)$value;
        $hours = (string)floor($value / 3600);
        $minutes = (string)floor(($value / 60) % 60);

        return str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutes, 2, '0', STR_PAD_LEFT);
    }
}
