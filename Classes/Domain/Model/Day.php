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

use Evoweb\Sessionplaner\Utility\ObjectStorageUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Day extends AbstractEntity
{
    protected string $name = '';

    protected string $date = '';

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

    public function setDate(string $date)
    {
        $this->date = $date;
    }

    public function getDate(): string
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
