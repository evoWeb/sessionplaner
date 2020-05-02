<?php

declare(strict_types=1);

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

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Speaker extends AbstractSlugEntity
{
    /**
     * @var string
     */
    protected $slugField = 'path_segment';

    /**
     * @var string
     */
    protected $tablename = 'tx_sessionplaner_domain_model_speaker';

    /**
     * @var bool
     */
    protected $hidden = false;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $bio = '';

    /**
     * @var string
     */
    protected $company = '';

    /**
     * @var string
     */
    protected $website = '';

    /**
     * @var string
     */
    protected $twitter = '';

    /**
     * @var string
     */
    protected $linkedin = '';

    /**
     * @var string
     */
    protected $xing = '';

    /**
     * @var string
     */
    protected $email = '';

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $picture;

    /**
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Session>
     */
    protected $sessions;

    /**
     * @var int
     */
    protected $detailPage;

    /**
     * @var string
     */
    protected $pathSegment;

    public function initializeObject()
    {
        $this->sessions = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectStorage::class);
    }

    public function setHidden(bool $hidden)
    {
        $this->hidden = $hidden;
    }

    public function getHidden(): bool
    {
        return $this->hidden;
    }

    public function setPathSegment(string $pathSegment)
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

    public function getSessions(): ObjectStorage
    {
        return $this->sessions;
    }

    public function setSessions(ObjectStorage $sessions): void
    {
        $this->sessions = $sessions;
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
}
