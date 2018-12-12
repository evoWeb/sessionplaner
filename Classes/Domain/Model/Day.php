<?php

/*
 * This file is part of the package Evoweb\Sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class Day extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $date = '';

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Room>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $rooms;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Slot>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $slots;

    public function __construct()
    {
        $this->rooms = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
        $this->slots = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
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
}
