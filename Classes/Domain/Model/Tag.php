<?php

/*
 * This file is part of the package Evoweb\Sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Domain\Model;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class Tag extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var string
     */
    protected $label = '';

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Evoweb\Sessionplaner\Domain\Model\Session>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $sessions;

    /**
     * Initialize day, room, slot and tags
     */
    public function __construct()
    {
        $this->sessions = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $sessions
     */
    public function setSessions(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $sessions)
    {
        $this->sessions = $sessions;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getSessions()
    {
        return $this->sessions;
    }
}
