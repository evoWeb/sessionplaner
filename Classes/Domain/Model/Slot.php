<?php
namespace Evoweb\Sessionplaner\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Sebastian Fischer <typo3@evoweb.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Utility\GeneralUtility;

class Slot extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var \DateTime
     */
    protected $start = '';

    /**
     * @var integer
     */
    protected $duration = 0;

    /**
     * @var boolean
     */
    protected $break = false;

    /**
     * @var boolean
     */
    protected $noBreakAfter = false;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Day>
     */
    protected $days;

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
        $this->days = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
        $this->rooms = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
        $this->sessions = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
    }

    /**
     * @param \DateTime $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return \DateTime
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
     * @param boolean $break
     */
    public function setBreak($break)
    {
        $this->break = $break;
    }

    /**
     * @return boolean
     */
    public function getBreak()
    {
        return $this->break;
    }

    /**
     * @param boolean $noBreakAfter
     */
    public function setNoBreakAfter($noBreakAfter)
    {
        $this->noBreakAfter = $noBreakAfter;
    }

    /**
     * @return boolean
     */
    public function getNoBreakAfter()
    {
        return $this->noBreakAfter;
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
