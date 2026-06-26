<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
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

    /**
     * @var array|string[]
     */
    protected static array $optionLabel = [
        self::OPTION_BEGINNER =>
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessionlevel.beginner',
        self::OPTION_ADVANCED =>
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessionlevel.advanced',
        self::OPTION_PRO =>
            'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.sessionlevel.pro',
    ];

    public static function getLabel(int $option): string
    {
        if (!isset(static::$optionLabel[$option])) {
            return 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.unknown';
        }
        return static::$optionLabel[$option];
    }

    /**
     * @return array<int, string>
     */
    public static function getOptions(): array
    {
        $data = [];
        $options = self::getAvailableOptions();
        foreach ($options as $option) {
            $data[$option] = self::getLabel($option);
        }
        return $data;
    }

    /**
     * @return array<int, array<string, string|int>>
     */
    public static function getTcaOptions(): array
    {
        $data = [
            [
                'label' => 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:option.none',
                'value' => 0,
            ],
        ];
        $options = self::getAvailableOptions();
        foreach ($options as $option) {
            $data[] = [
                'label' => self::getLabel($option),
                'value' => $option,
            ];
        }

        return $data;
    }

    /**
     * @return int[]
     */
    public static function getAvailableOptions(): array
    {
        return [
            self::OPTION_BEGINNER,
            self::OPTION_ADVANCED,
            self::OPTION_PRO,
        ];
    }
}
