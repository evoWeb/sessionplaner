<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\TitleTagProvider;

use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;

class SpeakerTitleTagProvider extends AbstractPageTitleProvider
{
    public function setTitle(string $title)
    {
        $this->title = $title;
    }
}
