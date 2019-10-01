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

use Evoweb\Sessionplaner\Utility\ObjectStorageUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Room extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $logo;

    /**
     * @var int
     */
    protected $seats = 0;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Day>
     */
    protected $days;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Slot>
     */
    protected $slots;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Session>
     */
    protected $sessions;

    public function initializeObject()
    {
        $this->days = GeneralUtility::makeInstance(ObjectStorage::class);
        $this->slots = GeneralUtility::makeInstance(ObjectStorage::class);
        $this->sessions = GeneralUtility::makeInstance(ObjectStorage::class);
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $logo
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param int $seats
     */
    public function setSeats($seats)
    {
        $this->seats = $seats;
    }

    /**
     * @return int
     */
    public function getSeats()
    {
        return $this->seats;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $days
     */
    public function setDays(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $days)
    {
        $this->days = $days;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $slots
     */
    public function setSlots(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $slots)
    {
        $this->slots = $slots;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getSlots()
    {
        return ObjectStorageUtility::sort($this->slots, 'start');
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $sessions
     */
    public function setSessions(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $sessions)
    {
        $this->sessions = $sessions;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getSessions()
    {
        return $this->sessions;
    }
}
