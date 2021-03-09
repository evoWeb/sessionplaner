<?php

declare(strict_types=1);

namespace Evoweb\Sessionplaner\Controller;

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

use Evoweb\Sessionplaner\Domain\Model\Speaker;
use Evoweb\Sessionplaner\Domain\Repository\SpeakerRepository;
use Evoweb\Sessionplaner\TitleTagProvider\SpeakerTitleTagProvider;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SpeakerController extends ActionController
{
    protected SpeakerRepository $speakerRepository;

    public function __construct(SpeakerRepository $speakerRepository)
    {
        $this->speakerRepository = $speakerRepository;
    }

    public function listAction(): ResponseInterface
    {
        $speakers = $this->speakerRepository->findAll();

        $this->view->assign('speakers', $speakers);

        return new HtmlResponse($this->view->render());
    }

    public function showAction(Speaker $speaker): ResponseInterface
    {
        /** @var SpeakerTitleTagProvider $provider */
        $provider = GeneralUtility::makeInstance(SpeakerTitleTagProvider::class);
        $provider->setTitle($speaker->getName());

        /** @var MetaTagManagerRegistry $metaTagRegistry */
        $metaTagRegistry = GeneralUtility::makeInstance(MetaTagManagerRegistry::class);

        $ogMetaTagManager = $metaTagRegistry->getManagerForProperty('og:title');
        $ogMetaTagManager->addProperty('og:title', $speaker->getName());

        $twitterMetaTagManager = $metaTagRegistry->getManagerForProperty('twitter:title');
        $twitterMetaTagManager->addProperty('twitter:title', $speaker->getName());

        $this->view->assign('speaker', $speaker);

        return new HtmlResponse($this->view->render());
    }
}
