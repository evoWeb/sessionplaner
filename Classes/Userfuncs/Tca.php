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
    public function slotLabel(array &$parameters)
    {
        $record = BackendUtility::getRecord($parameters['table'], $parameters['row']['uid']);
        if ($record === null) {
            return;
        }

        $record = BackendUtility::getRecord($parameters['table'], $parameters['row']['uid']);
        $start = TimeFormatUtility::getFormattedTime((int)$record['start']);
        $end = TimeFormatUtility::getFormattedTime((int)$record['start'] + ((int)$record['duration'] * 60));
        $breakInfo = $record['break'] === 1 ? ' - BREAK' : '';
        $dayInfo = '';

        if (!empty($record['day'])) {
            $day = BackendUtility::getRecord('tx_sessionplaner_domain_model_day', $record['day']);
            $dayInfo = ' (' . $day['name'] . ')';
        }

        $parameters['title'] = $start . ' - ' . $end . $breakInfo . $dayInfo;
    }
}
