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
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Day extends AbstractEntity
{
    protected string $name = '';

    protected \DateTime $date;

    /**
     * @var ObjectStorage<Room>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    public ObjectStorage $rooms;

    /**
     * @var ObjectStorage<Slot>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    public ObjectStorage $slots;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject()
    {
        $this->rooms = new ObjectStorage();
        $this->slots = new ObjectStorage();
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setRooms(ObjectStorage $rooms)
    {
        $this->rooms = $rooms;
    }

    public function getRooms(): ObjectStorage
    {
        return $this->rooms;
    }

    public function setSlots(ObjectStorage $slots)
    {
        $this->slots = $slots;
    }

    public function getSlots(): ObjectStorage
    {
        return ObjectStorageUtility::sort($this->slots, 'start');
    }
}
