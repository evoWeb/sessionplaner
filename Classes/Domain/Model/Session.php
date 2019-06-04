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

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Session extends AbstractEntity
{
    /**
     * @var bool
     */
    protected $hidden = false;

    /**
     * @var bool
     */
    protected $suggestion = false;

    /**
     * @var bool
     */
    protected $social = true;

    /**
     * @var bool
     */
    protected $donotlink = false;

    /**
     * @Extbase\Validate("NotEmpty")
     * @var string
     */
    protected $topic = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $speaker = '';

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Speaker>
     * @Extbase\ORM\Lazy
     */
    protected $speakers;

    /**
     * @var string
     */
    protected $twitter = '';

    /**
     * @var int
     */
    protected $attendees = 0;

    /**
     * @var int
     */
    protected $type = 0;

    /**
     * @var int
     */
    protected $level = 0;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @Extbase\ORM\Lazy
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
     * @Extbase\ORM\Lazy
     */
    protected $tags;

    /**
     * Initialize day, room, slot and tags
     */
    public function __construct()
    {
        $this->speakers = new ObjectStorage();
        $this->documents = new ObjectStorage();
        $this->tags = new ObjectStorage();
    }

    /**
     * @param bool $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * @return bool
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @param bool $social
     */
    public function setSocial($social)
    {
        $this->social = $social;
    }

    /**
     * @return bool
     */
    public function getSocial()
    {
        return $this->social;
    }

    /**
     * @param bool $donotlink
     */
    public function setDonotlink($donotlink)
    {
        $this->donotlink = $donotlink;
    }

    /**
     * @return bool
     */
    public function getDonotlink()
    {
        return $this->donotlink;
    }

    /**
     * @param bool $suggestion
     */
    public function setSuggestion($suggestion)
    {
        $this->suggestion = $suggestion;
    }

    /**
     * @return bool
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
     * @param Speaker $speaker
     */
    public function addSpeaker(Speaker $speaker)
    {
        $this->speakers->attach($speaker);
    }

    /**
     * @param Speaker $author
     */
    public function removeSpeaker(Speaker $speaker)
    {
        $this->speakers->detach($author);
    }

    /**
     * @return ObjectStorage
     */
    public function getSpeakers(): ObjectStorage
    {
        return $this->speakers;
    }

    /**
     * @param ObjectStorage $speaker
     */
    public function setSpeakers(ObjectStorage $speaker)
    {
        $this->speakers = $speakers;
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
     * @param int|\Evoweb\Sessionplaner\Domain\Model\Day $day
     */
    public function setDay($day)
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
     * @param int|\Evoweb\Sessionplaner\Domain\Model\Room $room
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
     * @param int|\Evoweb\Sessionplaner\Domain\Model\Slot $slot
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
