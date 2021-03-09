<?php

declare(strict_types=1);

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
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Slot extends AbstractEntity
{
    protected int $start = 0;

    protected int $duration = 0;

    protected bool $break = false;

    protected ?string $description = '';

    /**
     * @var ?Day
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ?Day $day;

    /**
     * @var ?ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Room>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ?ObjectStorage $rooms;

    /**
     * @var ?ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Session>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ?ObjectStorage $sessions;

    public function initializeObject()
    {
        $this->rooms = new ObjectStorage();
        $this->sessions = new ObjectStorage();
    }

    public function setStart(int $start)
    {
        $this->start = $start;
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function setDuration(int $duration)
    {
        $this->duration = $duration;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getEnd(): int
    {
        return $this->start + ($this->getDuration() * 60);
    }

    public function setBreak(bool $break)
    {
        $this->break = $break;
    }

    public function getBreak(): bool
    {
        return $this->break;
    }

    public function setDescription(?string $description)
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return (string)$this->description;
    }

    public function setDay(Day $day)
    {
        $this->day = $day;
    }

    public function getDay(): ?Day
    {
        return $this->day;
    }

    public function setRooms(ObjectStorage $rooms)
    {
        $this->rooms = $rooms;
    }

    public function getRooms(): ObjectStorage
    {
        return $this->rooms;
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
