<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Slot extends AbstractEntity
{
    protected int $start = 0;

    protected int $duration = 0;

    protected bool $break = false;

    protected ?string $description = '';

    protected ?Day $day = null;

    /**
     * @var ObjectStorage<Room>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $rooms;

    /**
     * @var ObjectStorage<Session>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $sessions;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->rooms = new ObjectStorage();
        $this->sessions = new ObjectStorage();
    }

    public function setStart(int $start): void
    {
        $this->start = $start;
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function setDuration(int $duration): void
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

    public function setBreak(bool $break): void
    {
        $this->break = $break;
    }

    public function getBreak(): bool
    {
        return $this->break;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return (string)$this->description;
    }

    public function setDay(Day $day): void
    {
        $this->day = $day;
    }

    public function getDay(): ?Day
    {
        return $this->day;
    }

    /**
     * @param ObjectStorage<Room> $rooms
     */
    public function setRooms(ObjectStorage $rooms): void
    {
        $this->rooms = $rooms;
    }

    /**
     * @return ObjectStorage<Room>
     */
    public function getRooms(): ObjectStorage
    {
        return $this->rooms;
    }

    /**
     * @param ObjectStorage<Session> $sessions
     */
    public function setSessions(ObjectStorage $sessions): void
    {
        $this->sessions = $sessions;
    }

    /**
     * @return ObjectStorage<Session>
     */
    public function getSessions(): ObjectStorage
    {
        return $this->sessions;
    }
}
