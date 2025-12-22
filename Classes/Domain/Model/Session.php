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
use TYPO3\CMS\Extbase\Annotation as Extbase;
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

    protected int $length = 0;

    protected int $level = 0;

    protected int $requesttype = 0;

    protected bool $norecording = false;

    protected ?Day $day = null;

    protected ?Room $room = null;

    protected ?Slot $slot = null;

    /**
     * @var ObjectStorage<Speaker>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $speakers;

    /**
     * @var ObjectStorage<FileReference>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $documents;

    /**
     * @var ObjectStorage<Tag>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $tags;

    /**
     * @var ObjectStorage<Link>
     */
    #[Extbase\ORM\Lazy]
    protected ObjectStorage $links;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->speakers = new ObjectStorage();
        $this->documents = new ObjectStorage();
        $this->tags = new ObjectStorage();
        $this->links = new ObjectStorage();
    }

    public function setHidden(bool $hidden): void
    {
        $this->hidden = $hidden;
    }

    public function getHidden(): bool
    {
        return $this->hidden;
    }

    public function setSocial(bool $social): void
    {
        $this->social = $social;
    }

    public function getSocial(): bool
    {
        return $this->social;
    }

    public function setDonotlink(bool $donotlink): void
    {
        $this->donotlink = $donotlink;
    }

    public function getDonotlink(): bool
    {
        return $this->donotlink;
    }

    public function setSuggestion(bool $suggestion): void
    {
        $this->suggestion = $suggestion;
    }

    public function getSuggestion(): bool
    {
        return $this->suggestion;
    }

    public function setTopic(string $topic): void
    {
        $this->topic = $topic;
    }

    public function getTopic(): string
    {
        return $this->topic;
    }

    public function setPathSegment(string $pathSegment): void
    {
        $this->pathSegment = $pathSegment;
    }

    public function getPathSegment(): string
    {
        return $this->pathSegment;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function addSpeaker(Speaker $speaker): void
    {
        $this->speakers->attach($speaker);
    }

    public function removeSpeaker(Speaker $speaker): void
    {
        $this->speakers->detach($speaker);
    }

    /**
     * @return ObjectStorage<Speaker>
     */
    public function getSpeakers(): ObjectStorage
    {
        return $this->speakers;
    }

    /**
     * @param ObjectStorage<Speaker> $speakers
     */
    public function setSpeakers(ObjectStorage $speakers): void
    {
        $this->speakers = $speakers;
    }

    public function setSpeaker(string $speaker): void
    {
        $this->speaker = $speaker;
    }

    public function getSpeaker(): string
    {
        return $this->speaker;
    }

    public function setTwitter(string $twitter): void
    {
        $this->twitter = $twitter;
    }

    public function getTwitter(): string
    {
        return $this->twitter;
    }

    public function setAttendees(int $attendees): void
    {
        $this->attendees = $attendees;
    }

    public function getAttendees(): int
    {
        return $this->attendees;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setRequesttype(int $requesttype): void
    {
        $this->requesttype = $requesttype;
    }

    public function getRequesttype(): int
    {
        return $this->requesttype;
    }

    public function setNorecording(bool $norecording): void
    {
        $this->norecording = $norecording;
    }

    public function isNorecording(): bool
    {
        return $this->norecording;
    }

    public function getNorecording(): bool
    {
        return $this->norecording;
    }

    /**
     * @param ObjectStorage<FileReference> $documents
     */
    public function setDocuments(ObjectStorage $documents): void
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

    public function setDay(?Day $day): void
    {
        $this->day = $day;
    }

    public function getDay(): ?Day
    {
        return $this->day;
    }

    public function setRoom(?Room $room): void
    {
        $this->room = $room;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setSlot(?Slot $slot): void
    {
        $this->slot = $slot;
    }

    public function getSlot(): ?Slot
    {
        return $this->slot;
    }

    /**
     * @param ObjectStorage<Tag> $tags
     */
    public function setTags(ObjectStorage $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return ObjectStorage<Tag>
     */
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
            $value = \is_object($value) && \method_exists($value, 'getUid') ? $value->getUid() : $value;
            $data[$field] = $value;
        }

        return $data;
    }

    /**
     * @return ObjectStorage<Link>
     */
    public function getLinks(): ObjectStorage
    {
        return $this->links;
    }

    /**
     * @param ObjectStorage<Link> $links
     */
    public function setLinks(ObjectStorage $links): void
    {
        $this->links = $links;
    }
}
