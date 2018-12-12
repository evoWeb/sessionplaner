<?php

/*
 * This file is part of the package Evoweb\Sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class Room extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
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
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Day>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $days;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Slot>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $slots;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Session>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $sessions;

    /**
     * Initialize days and slots
     */
    public function __construct()
    {
        $this->days = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
        $this->slots = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
        $this->sessions = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
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
        return $this->slots;
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
