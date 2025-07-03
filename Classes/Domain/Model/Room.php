<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Domain\Model;

use Evoweb\Sessionplaner\Utility\ObjectStorageUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Room extends AbstractEntity
{
    protected string $type = '';

    protected string $name = '';

    protected ?FileReference $logo = null;

    protected int $seats = 0;

    /**
     * @var ObjectStorage<Day>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ObjectStorage $days;

    /**
     * @var ObjectStorage<Slot>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ObjectStorage $slots;

    /**
     * @var ObjectStorage<Session>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ObjectStorage $sessions;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->days = new ObjectStorage();
        $this->slots = new ObjectStorage();
        $this->sessions = new ObjectStorage();
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setLogo(FileReference $logo): void
    {
        $this->logo = $logo;
    }

    public function getLogo(): ?FileReference
    {
        return $this->logo;
    }

    public function setSeats(int $seats): void
    {
        $this->seats = $seats;
    }

    public function getSeats(): int
    {
        return $this->seats;
    }

    /**
     * @param ObjectStorage<Day> $days
     */
    public function setDays(ObjectStorage $days): void
    {
        $this->days = $days;
    }

    /**
     * @return ObjectStorage<Day>
     */
    public function getDays(): ObjectStorage
    {
        return $this->days;
    }

    /**
     * @param ObjectStorage<Slot> $slots
     */
    public function setSlots(ObjectStorage $slots): void
    {
        $this->slots = $slots;
    }

    /**
     * @return ObjectStorage<Slot>
     */
    public function getSlots(): ObjectStorage
    {
        return ObjectStorageUtility::sort($this->slots, 'start');
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
