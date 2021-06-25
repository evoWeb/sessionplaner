<?php

declare(strict_types=1);

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

namespace Evoweb\Sessionplaner\Enum;

class SessionLevelEnum
{
    public const OPTION_BEGINNER = 1;
    public const OPTION_ADVANCED = 2;
    public const OPTION_PRO = 3;
    public const OPTION_ALL = 4;

    protected static $optionLabel = [
        self::OPTION_BEGINNER =>
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessionlevel.beginner',
        self::OPTION_ADVANCED =>
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessionlevel.advanced',
        self::OPTION_PRO =>
	'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessionlevel.pro',
        self::OPTION_ALL =>
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessionlevel.all'
    ];

    public static function getLabel(int $option): string
    {
        if (!isset(static::$optionLabel[$option])) {
            return 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.unknown';
        }
        return static::$optionLabel[$option];
    }

    public static function getOptions(): array
    {
        $data = [];
        $options = self::getAvailableOptions();
        foreach ($options as $option) {
            $data[$option] = self::getLabel($option);
        }
        return $data;
    }

    public static function getTcaOptions(): array
    {
        $data = [];
        $options = self::getAvailableOptions();
        foreach ($options as $option) {
            $data[] = [self::getLabel($option), $option];
        }

        return $data;
    }

    public static function getAvailableOptions(): array
    {
        return [
            self::OPTION_BEGINNER,
            self::OPTION_ADVANCED,
	        self::OPTION_PRO,
	        self::OPTION_ALL
        ];
    }
}
