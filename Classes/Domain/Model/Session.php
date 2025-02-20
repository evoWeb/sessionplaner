<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Session extends AbstractSlugEntity
{
    protected string $slugField = 'path_segment';

    protected string $tablename = 'tx_sessionplaner_domain_model_session';

    protected bool $hidden = false;

    protected bool $suggestion = false;

    protected bool $social = true;

    protected bool $donotlink = false;

    /**
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected string $topic = '';

    protected string $pathSegment = '';

    protected string $description = '';

    protected string $speaker = '';

    protected string $twitter = '';

    protected int $attendees = 0;

    protected int $type = 0;

    protected int $level = 0;

    protected int $requesttype = 0;

    protected bool $norecording = false;

    protected ?Day $day = null;

    protected ?Room $room = null;

    protected ?Slot $slot = null;

    /**
     * @var ObjectStorage<Speaker>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ObjectStorage $speakers;

    /**
     * @var ObjectStorage<FileReference>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ObjectStorage $documents;

    /**
     * @var ObjectStorage<Tag>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ObjectStorage $tags;

    /**
     * @var ObjectStorage<Link>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ObjectStorage $links;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject()
    {
        $this->speakers = new ObjectStorage();
        $this->documents = new ObjectStorage();
        $this->tags = new ObjectStorage();
        $this->links = new ObjectStorage();
    }

    public function setHidden($hidden)
    {
        $this->hidden = (bool)$hidden;
    }

    public function getHidden(): bool
    {
        return $this->hidden;
    }

    public function setSocial($social)
    {
        $this->social = (bool)$social;
    }

    public function getSocial(): bool
    {
        return $this->social;
    }

    public function setDonotlink($donotlink)
    {
        $this->donotlink = (bool)$donotlink;
    }

    public function getDonotlink(): bool
    {
        return $this->donotlink;
    }

    public function setSuggestion($suggestion)
    {
        $this->suggestion = (bool)$suggestion;
    }

    public function getSuggestion(): bool
    {
        return $this->suggestion;
    }

    public function setTopic(string $topic)
    {
        $this->topic = $topic;
    }

    public function getTopic(): string
    {
        return $this->topic;
    }

    public function setPathSegment(string $pathSegment)
    {
        $this->pathSegment = $pathSegment;
    }

    public function getPathSegment(): string
    {
        return $this->pathSegment;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function addSpeaker(Speaker $speaker)
    {
        $this->speakers->attach($speaker);
    }

    public function removeSpeaker(Speaker $speaker)
    {
        $this->speakers->detach($speaker);
    }

    public function getSpeakers(): ObjectStorage
    {
        return $this->speakers;
    }

    public function setSpeakers(ObjectStorage $speakers)
    {
        $this->speakers = $speakers;
    }

    public function setSpeaker(string $speaker)
    {
        $this->speaker = $speaker;
    }

    public function getSpeaker(): string
    {
        return $this->speaker;
    }

    public function setTwitter(string $twitter)
    {
        $this->twitter = $twitter;
    }

    public function getTwitter(): string
    {
        return $this->twitter;
    }

    public function setAttendees($attendees)
    {
        $this->attendees = (int)$attendees;
    }

    public function getAttendees(): int
    {
        return $this->attendees;
    }

    public function setType($type)
    {
        $this->type = (int)$type;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setLevel($level)
    {
        $this->level = (int)$level;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setRequesttype($requesttype)
    {
        $this->requesttype = (int)$requesttype;
    }

    public function getRequesttype(): int
    {
        return $this->requesttype;
    }

    public function setNorecording($norecording)
    {
        $this->norecording = (bool)$norecording;
    }

    public function isNorecording(): bool
    {
        return $this->norecording;
    }

    public function getNorecording(): bool
    {
        return $this->norecording;
    }

    public function setDocuments(ObjectStorage $documents)
    {
        $this->documents = $documents;
    }

    public function getDocuments(): array
    {
        $result = [];
        /** @var FileReference $file */
        foreach ($this->documents as $file) {
            $result[] = $file->getOriginalResource();
        }
        return $result;
    }

    public function setDay(?Day $day)
    {
        $this->day = $day;
    }

    public function getDay(): ?Day
    {
        $day = $this->day;
        if (!empty($day) && $day !== 0) {
            return $day;
        }
        return null;
    }

    public function setRoom(?Room $room)
    {
        $this->room = $room;
    }

    public function getRoom(): ?Room
    {
        $room = $this->room;
        if (!empty($room) && $room !== 0) {
            return $room;
        }
        return null;
    }

    public function setSlot(?Slot $slot)
    {
        $this->slot = $slot;
    }

    public function getSlot(): ?Slot
    {
        $slot = $this->slot;
        if (!empty($slot) && $slot !== 0) {
            return $slot;
        }
        return null;
    }

    public function setTags(ObjectStorage $tags)
    {
        $this->tags = $tags;
    }

    public function getTags(): ObjectStorage
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): void
    {
        $this->tags->attach($tag);
    }

    public function removeTag(Tag $tag): void
    {
        $this->tags->detach($tag);
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

    public function getLinks(): ObjectStorage
    {
        return $this->links;
    }

    public function setLinks(ObjectStorage $links)
    {
        $this->links = $links;
    }
}
