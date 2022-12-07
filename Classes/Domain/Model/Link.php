<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Link extends AbstractEntity
{
    protected string $link = '';

    protected string $linkText = '';

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link)
    {
        $this->link = $link;
    }

    public function getLinkText(): string
    {
        return $this->linkText;
    }

    public function setLinkText(string $linkText)
    {
        $this->linkText = $linkText;
    }
}
