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
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Tag extends AbstractEntity
{
    /**
     * @var string
     */
    protected string $label = '';

    /**
     * @var string
     */
    protected string $color = '';

    /**
     * @var ObjectStorage<Session>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ObjectStorage $sessions;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject()
    {
        $this->sessions = new ObjectStorage();
    }

    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setColor(string $color)
    {
        $this->color = $color;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setSessions(ObjectStorage $sessions)
    {
        $this->sessions = $sessions;
    }

    public function getSessions(): ObjectStorage
    {
        return $this->sessions;
    }
}
