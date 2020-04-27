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

namespace Evoweb\Sessionplaner\Userfuncs;

use Evoweb\Sessionplaner\Utility\TimeFormatUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;

class Tca
{
    public function slotLabel(array &$parameters)
    {
        $record = BackendUtility::getRecord($parameters['table'], $parameters['row']['uid']);
        $start = TimeFormatUtility::getFormattedTime((int) $record['start']);
        $end = TimeFormatUtility::getFormattedTime((int) $record['start'] + ((int) $record['duration'] * 60));
        $breakInfo = $record['break'] === 1 ? ' - BREAK' : '';
        $parameters['title'] = $start . ' - ' . $end . $breakInfo;
    }
}
