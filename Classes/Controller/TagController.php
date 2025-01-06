<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Controller;

use Evoweb\Sessionplaner\Domain\Model\Tag;
use Evoweb\Sessionplaner\TitleTagProvider\TagTitleTagProvider;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Exception\Page\PageNotFoundException;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class TagController extends ActionController
{
    public function showAction(Tag $tag): ResponseInterface
    {
        if (!$tag->hasActiveSessions()) {
            throw new PageNotFoundException('The requested tag was not found', 1735908029);
        }

        /** @var TagTitleTagProvider $provider */
        $provider = GeneralUtility::makeInstance(TagTitleTagProvider::class);
        $provider->setTitle($tag->getLabel());

        /** @var MetaTagManagerRegistry $metaTagRegistry */
        $metaTagRegistry = GeneralUtility::makeInstance(MetaTagManagerRegistry::class);

        $ogMetaTagManager = $metaTagRegistry->getManagerForProperty('og:title');
        $ogMetaTagManager->addProperty('og:title', $tag->getLabel());

        $twitterMetaTagManager = $metaTagRegistry->getManagerForProperty('twitter:title');
        $twitterMetaTagManager->addProperty('twitter:title', $tag->getLabel());

        $this->view->assign('tag', $tag);

        return new HtmlResponse($this->view->render());
    }
}
