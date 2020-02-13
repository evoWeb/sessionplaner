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

class SessionTypeEnum
{
    const OPTION_TALK = 1;
    const OPTION_TUTORIAL = 2;
    const OPTION_WORKSHOP = 3;
    const OPTION_DISCUSSION = 4;

    protected static $optionLabel = [
        self::OPTION_TALK => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessiontype.talk',
        self::OPTION_TUTORIAL => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessiontype.tutorial',
        self::OPTION_WORKSHOP => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessiontype.workshop',
        self::OPTION_DISCUSSION => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessiontype.discussion'
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
            self::OPTION_TALK,
            self::OPTION_TUTORIAL,
            self::OPTION_WORKSHOP,
            self::OPTION_DISCUSSION
        ];
    }
}
