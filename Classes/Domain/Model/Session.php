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
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Session extends AbstractSlugEntity
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
    protected $pathSegment = '';

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
    protected $day = null;

    /**
     * @var \Evoweb\Sessionplaner\Domain\Model\Room
     */
    protected $room = null;

    /**
     * @var \Evoweb\Sessionplaner\Domain\Model\Slot
     */
    protected $slot = null;

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
        $this->slugField = 'path_segment';
        $this->tablename = 'tx_sessionplaner_domain_model_session';
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
     * @param string $pathSegment
     */
    public function setPathSegment($pathSegment)
    {
        $this->pathSegment = $pathSegment;
    }

    /**
     * @return string
     */
    public function getPathSegment()
    {
        return $this->pathSegment;
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

    public function setDay(?Day $day)
    {
        $this->day = $day ?? 0;
    }

    public function getDay(): ?Day
    {
        $day = $this->day;
        if (!empty($day) && $day !== 0) {
            return $day;
        } else {
            return null;
        }
    }

    public function setRoom(?Room $room)
    {
        $this->room = $room ?? 0;
    }

    public function getRoom(): ?Room
    {
        $room = $this->room;
        if (!empty($room) && $room !== 0) {
            return $room;
        } else {
            return null;
        }
    }

    public function setSlot(?Slot $slot)
    {
        $this->slot = $slot ?? 0;
    }

    public function getSlot(): ?Slot
    {
        $slot = $this->slot;
        if (!empty($slot) && $slot !== 0) {
            return $slot;
        } else {
            return null;
        }
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

    public function toArray(): array
    {
        $data = [];
        $properties = $this->_getProperties();
        foreach ($properties as $key => $value) {
            $field = GeneralUtility::camelCaseToLowerCaseUnderscored($key);
            $value = \is_object($value) && \method_exists($value, 'getUid') ? $value->getUid() :  $value;
            $data[$field] = $value;
        }

        return $data;
    }
}
