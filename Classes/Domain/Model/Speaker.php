<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Speaker extends AbstractSlugEntity
{
    protected string $slugField = 'path_segment';
    protected string $tablename = 'tx_sessionplaner_domain_model_speaker';
    protected bool $hidden = false;
    protected string $name = '';
    protected string $bio = '';
    protected string $company = '';
    protected string $website = '';
    protected string $twitter = '';
    protected string $linkedin = '';
    protected string $xing = '';
    protected string $email = '';
    protected ?FileReference $picture = null;
    protected int $detailPage = 0;
    protected string $pathSegment = '';

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
        $this->sessions =  new ObjectStorage();
    }

    public function setHidden(bool $hidden): void
    {
        $this->hidden = $hidden;
    }

    public function getHidden(): bool
    {
        return $this->hidden;
    }

    public function setPathSegment(string $pathSegment): void
    {
        $this->pathSegment = $pathSegment;
    }

    public function getPathSegment(): string
    {
        return $this->pathSegment;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
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

    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function setWebsite(string $website): void
    {
        $this->website = $website;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function setTwitter(string $twitter): void
    {
        $this->twitter = $twitter;
    }

    public function getTwitter(): string
    {
        return $this->twitter;
    }

    public function setLinkedin(string $linkedin): void
    {
        $this->linkedin = $linkedin;
    }

    public function getLinkedin(): string
    {
        return $this->linkedin;
    }

    public function setXing(string $xing): void
    {
        $this->xing = $xing;
    }

    public function getXing(): string
    {
        return $this->xing;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPicture(FileReference $picture): void
    {
        $this->picture = $picture;
    }

    public function getPicture(): ?FileReference
    {
        return $this->picture;
    }

    public function setDetailPage(int $detailPage): void
    {
        $this->detailPage = $detailPage;
    }

    public function getDetailPage(): int
    {
        return $this->detailPage;
    }

    public function setBio(string $bio): void
    {
        $this->bio = $bio;
    }

    public function getBio(): string
    {
        return $this->bio;
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
