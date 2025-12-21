<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Userfuncs;

use Evoweb\Sessionplaner\Utility\TimeFormatUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;

class Tca
{
    /**
     * @param array{table: string, row: array} $parameters
     */
    public function slotLabel(array &$parameters): void
    {
        $record = BackendUtility::getRecord($parameters['table'], $parameters['row']['uid'] ?? -1);
        if ($record === null) {
            return;
        }

        $start = isset($record['start']) ? (int)$record['start'] : 0;
        $duration = isset($record['duration']) ? (int)$record['duration'] : 0;
        $break = isset($record['break']) && (int)$record['break'] === 1 ? ' - BREAK' : '';
        $dayInfo = '';

        if (isset($record['day']) && (int)$record['day'] > 0) {
            $day = BackendUtility::getRecord('tx_sessionplaner_domain_model_day', (int)$record['day']);
            if (is_array($day) && isset($day['name'])) {
                $dayInfo = ' (' . $day['name'] . ')';
            }
        }

        $startFormatted = TimeFormatUtility::getFormattedTime($start);
        $endFormatted = TimeFormatUtility::getFormattedTime($start + ($duration * 60));
        $parameters['title'] = $startFormatted . ' - ' . $endFormatted . $break . $dayInfo;
    }
}
