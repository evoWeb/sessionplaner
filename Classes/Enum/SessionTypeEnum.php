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
    public const OPTION_TALK = 1;
    public const OPTION_TUTORIAL = 2;
    public const OPTION_WORKSHOP = 3;
    public const OPTION_DISCUSSION = 4;
    public const OPTION_SESSION = 5;
    public const OPTION_BREAK = 6;
    public const OPTION_WISH = 7;
    public const OPTION_OTHER = 8;

    protected static $optionLabel = [
        self::OPTION_TALK =>
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessiontype.talk',
        self::OPTION_TUTORIAL =>
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessiontype.tutorial',
        self::OPTION_WORKSHOP =>
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessiontype.workshop',
        self::OPTION_DISCUSSION =>
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessiontype.discussion',
        self::OPTION_SESSION =>
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessiontype.session',
        self::OPTION_BREAK =>
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessiontype.break',
        self::OPTION_WISH =>
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessiontype.wish',
        self::OPTION_OTHER =>
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessiontype.other'
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
	        self::OPTION_DISCUSSION,
            self::OPTION_SESSION,
            self::OPTION_BREAK,
            self::OPTION_WISH,
            self::OPTION_OTHER
        ];
    }
}
