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

    public function initializeObject()
    {
        $this->days = new ObjectStorage();
        $this->slots = new ObjectStorage();
        $this->sessions = new ObjectStorage();
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setLogo(FileReference $logo)
    {
        $this->logo = $logo;
    }

    public function getLogo(): ?FileReference
    {
        return $this->logo;
    }

    public function setSeats(int $seats)
    {
        $this->seats = $seats;
    }

    public function getSeats(): int
    {
        return $this->seats;
    }

    public function setDays(ObjectStorage $days)
    {
        $this->days = $days;
    }

    public function getDays(): ObjectStorage
    {
        return $this->days;
    }

    public function setSlots(ObjectStorage $slots)
    {
        $this->slots = $slots;
    }

    public function getSlots(): ObjectStorage
    {
        return ObjectStorageUtility::sort($this->slots, 'start');
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
