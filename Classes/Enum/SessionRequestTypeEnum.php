<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Enum;

class SessionRequestTypeEnum
{
    public const OPTION_OFFER = 1;
    public const OPTION_WISH = 2;

    protected static array $optionLabel = [
        self::OPTION_OFFER =>
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessionrequesttype.offer',
        self::OPTION_WISH =>
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessionrequesttype.wish',
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
            self::OPTION_OFFER,
            self::OPTION_WISH
        ];
    }
}
