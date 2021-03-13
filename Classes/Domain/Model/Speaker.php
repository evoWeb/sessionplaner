<?php

declare(strict_types=1);

namespace Evoweb\Sessionplaner\Domain\Model;

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

    /**
     * @var ObjectStorage<Session>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected ObjectStorage $sessions;

    protected int $detailPage = 0;

    protected string $pathSegment = '';

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject()
    {
        $this->sessions =  new ObjectStorage();
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

    public function setName(string $name)
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

    public function setSessions(ObjectStorage $sessions)
    {
        $this->sessions = $sessions;
    }

    public function setCompany(string $company)
    {
        $this->company = $company;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function setWebsite(string $website)
    {
        $this->website = $website;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function setTwitter(string $twitter)
    {
        $this->twitter = $twitter;
    }

    public function getTwitter(): string
    {
        return $this->twitter;
    }

    public function setLinkedin(string $linkedin)
    {
        $this->linkedin = $linkedin;
    }

    public function getLinkedin(): string
    {
        return $this->linkedin;
    }

    public function setXing(string $xing)
    {
        $this->xing = $xing;
    }

    public function getXing(): string
    {
        return $this->xing;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPicture(FileReference $picture)
    {
        $this->picture = $picture;
    }

    public function getPicture(): ?FileReference
    {
        return $this->picture;
    }

    public function setDetailPage(int $detailPage)
    {
        $this->detailPage = $detailPage;
    }

    public function getDetailPage(): int
    {
        return $this->detailPage;
    }

    public function setBio(string $bio)
    {
        $this->bio = $bio;
    }

    public function getBio(): string
    {
        return $this->bio;
    }
}
