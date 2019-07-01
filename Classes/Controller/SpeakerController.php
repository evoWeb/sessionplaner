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

namespace Evoweb\Sessionplaner\Controller;

use Evoweb\Sessionplaner\Domain\Model\Speaker;
use Evoweb\Sessionplaner\TitleTagProvider\SpeakerTitleTagProvider;
use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SpeakerController extends ActionController
{
    /**
     * @var \Evoweb\Sessionplaner\Domain\Repository\SpeakerRepository
     */
    protected $speakerRepository;

    /**
     * @param \Evoweb\Sessionplaner\Domain\Repository\SpeakerRepository $speakerRepository
     */
    public function injectSpeakerRepository(\Evoweb\Sessionplaner\Domain\Repository\SpeakerRepository $speakerRepository)
    {
        $this->speakerRepository = $speakerRepository;
    }

    /**
     * @return void
     */
    public function listAction()
    {
        $speakers = $this->speakerRepository->findAll();

        $this->view->assign('speakers', $speakers);
    }

    /**
     * @param Speaker $speaker
     */
    public function showAction(Speaker $speaker)
    {
        $provider = GeneralUtility::makeInstance(SpeakerTitleTagProvider::class);
        $provider->setTitle($speaker->getName());

        $ogMetaTagManager = GeneralUtility::makeInstance(MetaTagManagerRegistry::class)->getManagerForProperty('og:title');
        $ogMetaTagManager->addProperty('og:title', $speaker->getName());

        $twitterMetaTagManager = GeneralUtility::makeInstance(MetaTagManagerRegistry::class)->getManagerForProperty('twitter:title');
        $twitterMetaTagManager->addProperty('twitter:title', $speaker->getName());

        $this->view->assign('speaker', $speaker);
    }
}
