<?php

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

namespace Evoweb\Sessionplaner\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class Slot extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var int
     */
    protected $start = 0;

    /**
     * @var int
     */
    protected $duration = 0;

    /**
     * @var bool
     */
    protected $break = false;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $noBreakAfter = false;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var \Evoweb\Sessionplaner\Domain\Model\Day
     */
    protected $day;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Room>
     */
    protected $rooms;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Session>
     */
    protected $sessions;

    public function __construct()
    {
        $this->rooms = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
        $this->sessions = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
    }

    /**
     * @param int $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param int $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return int
     */
    public function getEnd()
    {
        return $this->start + ($this->getDuration() * 60);
    }

    /**
     * @param bool $break
     */
    public function setBreak($break)
    {
        $this->break = $break;
    }

    /**
     * @return bool
     */
    public function getBreak()
    {
        return $this->break;
    }

    public function setDescription(?string $description)
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param bool $noBreakAfter
     */
    public function setNoBreakAfter($noBreakAfter)
    {
        $this->noBreakAfter = $noBreakAfter;
    }

    /**
     * @return bool
     */
    public function getNoBreakAfter()
    {
        return $this->noBreakAfter;
    }

    /**
     * @param \Evoweb\Sessionplaner\Domain\Model\Day $day
     */
    public function setDay(\Evoweb\Sessionplaner\Domain\Model\Day $day)
    {
        $this->day = $day;
    }

    /**
     * @return \Evoweb\Sessionplaner\Domain\Model\Day
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $rooms
     */
    public function setRooms(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $rooms)
    {
        $this->rooms = $rooms;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getRooms()
    {
        return $this->rooms;
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
