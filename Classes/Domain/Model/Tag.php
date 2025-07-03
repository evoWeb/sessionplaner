<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Tag extends AbstractEntity
{
    /**
     * @var string
     */
    protected string $label = '';

    /**
     * @var string
     */
    protected string $color = '';

    /**
     * @var string
     */
    protected string $description = '';

    /**
     * @var string
     */
    protected string $slug = '';

    /**
     * @var bool
     */
    protected bool $suggestFormOption = false;

    /**
     * @var ObjectStorage<Session>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ObjectStorage $sessions;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->sessions = new ObjectStorage();
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSuggestFormOption(bool $suggestFormOption): void
    {
        $this->suggestFormOption = $suggestFormOption;
    }

    public function isSuggestFormOption(): bool
    {
        return $this->suggestFormOption;
    }

    /**
     * @param ObjectStorage<Session> $sessions
     */
    public function setSessions(ObjectStorage $sessions): void
    {
        $this->sessions = $sessions;
    }

    /**
     * @return ObjectStorage<Session>
     */
    public function getSessions(): ObjectStorage
    {
        return $this->sessions;
    }

    public function hasActiveSessions(): bool
    {
        foreach ($this->getSessions() as $session) {
            if ($session->getDay() !== null && $session->getSlot() !== null) {
                return true;
            }
        }

        return false;
    }
}
