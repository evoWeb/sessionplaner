<?php
declare(strict_types = 1);
namespace Evoweb\Sessionplaner\Domain\Model;

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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Link extends AbstractEntity
{
    /**
     * @var string
     */
    protected $link = '';

    /**
     * @var string
     */
    protected $linkText = '';

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getLinkText(): string
    {
        return $this->linkText;
    }

    /**
     * @param string $linkText
     */
    public function setLinkText(string $linkText): void
    {
        $this->linkText = $linkText;
    }
}
