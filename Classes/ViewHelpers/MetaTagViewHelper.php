<?php

/*
 * This file is part of the package Evoweb\Sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class MetaTagViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'meta';

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerTagAttribute('property', 'string', 'Property of meta tag');
        $this->registerTagAttribute('content', 'string', 'Content of meta tag');
    }

    /**
     * @param bool $useCurrentDomain
     * @param bool $forceAbsoluteUrl
     * @param bool $useNameAttribute
     * @return void
     */
    public function render($useCurrentDomain = false, $forceAbsoluteUrl = false, $useNameAttribute = false)
    {
        if ($useCurrentDomain) {
            $this->tag->addAttribute(
                'content',
                GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL')
            );
        }
        if ($forceAbsoluteUrl) {
            $path = $this->arguments['content'];
            if (!GeneralUtility::isFirstPartOfStr($path, GeneralUtility::getIndpEnv('TYPO3_SITE_URL'))) {
                $this->tag->addAttribute(
                    'content',
                    GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . $this->arguments['content']
                );
            }
        }
        if ($useCurrentDomain || (isset($this->arguments['content']) && !empty($this->arguments['content']))) {
            if ($useNameAttribute && $this->arguments['property'] !== '') {
                $attributesContent = $this->arguments['property'];
                $this->tag->removeAttribute('property');
                $this->tag->addAttribute('name', $attributesContent);
            }
            $this->getPageRenderer()->addMetaTag($this->tag->render());
        }
    }

    /**
     * @return \TYPO3\CMS\Core\Page\PageRenderer
     */
    protected function getPageRenderer()
    {
        /** @var \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer */
        $pageRenderer = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
        return $pageRenderer;
    }
}
