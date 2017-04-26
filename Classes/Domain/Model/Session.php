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

class Session extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var boolean
     */
    protected $hidden = false;

    /**
     * @var boolean
     */
    protected $suggestion = false;

    /**
     * @var boolean
     */
    protected $social = true;

    /**
     * @var boolean
     */
    protected $donotlink = false;

    /**
     * @var string
     * @validate NotEmpty
     */
    protected $topic = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     * @validate NotEmpty
     */
    protected $speaker = '';

    /**
     * @var string
     */
    protected $twitter = '';

    /**
     * @var integer
     */
    protected $attendees = 0;

    /**
     * @var integer
     */
    protected $type = 0;

    /**
     * @var integer
     */
    protected $level = 0;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $documents;

    /**
     * @var \Evoweb\Sessionplaner\Domain\Model\Day
     */
    protected $day;

    /**
     * @var \Evoweb\Sessionplaner\Domain\Model\Room
     */
    protected $room;

    /**
     * @var \Evoweb\Sessionplaner\Domain\Model\Slot
     */
    protected $slot;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Tag>
     * @lazy
     */
    protected $tags;

    /**
     * Initialize day, room, slot and tags
     */
    public function __construct()
    {
        $this->documents = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
        $this->tags = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
    }

    /**
     * @param boolean $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * @return boolean
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @param boolean $social
     */
    public function setSocial($social)
    {
        $this->social = $social;
    }

    /**
     * @return boolean
     */
    public function getSocial()
    {
        return $this->social;
    }

    /**
     * @param boolean $donotlink
     */
    public function setDonotlink($donotlink)
    {
        $this->donotlink = $donotlink;
    }

    /**
     * @return boolean
     */
    public function getDonotlink()
    {
        return $this->donotlink;
    }

    /**
     * @param boolean $suggestion
     */
    public function setSuggestion($suggestion)
    {
        $this->hidden = $suggestion;
    }

    /**
     * @return boolean
     */
    public function getSuggestion()
    {
        return $this->suggestion;
    }

    /**
     * @param string $topic
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
    }

    /**
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $speaker
     */
    public function setSpeaker($speaker)
    {
        $this->speaker = $speaker;
    }

    /**
     * @return string
     */
    public function getSpeaker()
    {
        return $this->speaker;
    }

    /**
     * @param string $twitter
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @param int $attendees
     */
    public function setAttendees($attendees)
    {
        $this->attendees = $attendees;
    }

    /**
     * @return int
     */
    public function getAttendees()
    {
        return $this->attendees;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $documents
     */
    public function setDocuments(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $documents)
    {
        $this->documents = $documents;
    }

    /**
     * @return array
     */
    public function getDocuments()
    {
        $result = [];
        foreach ($this->documents as $file) {
            $result[] = $file->getOriginalResource();
        }
        return $result;
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
     * @param integer|\Evoweb\Sessionplaner\Domain\Model\Room $room
     */
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * @return \Evoweb\Sessionplaner\Domain\Model\Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param integer|\Evoweb\Sessionplaner\Domain\Model\Slot $slot
     */
    public function setSlot($slot)
    {
        $this->slot = $slot;
    }

    /**
     * @return \Evoweb\Sessionplaner\Domain\Model\Slot
     */
    public function getSlot()
    {
        return $this->slot;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $tags
     */
    public function setTags(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getTags()
    {
        return $this->tags;
    }
}
