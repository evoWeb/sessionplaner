<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\ViewHelpers\Format;

use Evoweb\Sessionplaner\Utility\TimeFormatUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class TimeViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('value', 'int', 'integer to format', true, 0);
    }

    public function render(): string
    {
        return TimeFormatUtility::getFormattedTime((int)$this->arguments['value']);
    }
}
