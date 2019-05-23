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

namespace Evoweb\Sessionplaner\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class MetaTagViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    public function initializeArguments()
    {
        $this->registerArgument('property', 'string', 'Property of meta tag');
        $this->registerArgument('content', 'string', 'Content of meta tag');
        $this->registerArgument('useCurrentDomain', 'bool', 'Use current domain', false, false);
        $this->registerArgument('forceAbsoluteUrl', 'bool', 'Force absolute url', false, false);
        $this->registerArgument('useNameAttribute', 'bool', 'Use name attribute', false, false);
    }

    public function render()
    {
        $useCurrentDomain = $this->arguments['useCurrentDomain'];
        $forceAbsoluteUrl = $this->arguments['forceAbsoluteUrl'];
        $useNameAttribute = $this->arguments['useNameAttribute'];

        $content = $this->arguments['content'];
        $type = 'property';
        if ($useCurrentDomain) {
            $content = GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL');
        }
        if ($forceAbsoluteUrl) {
            $path = $this->arguments['content'];
            if (!GeneralUtility::isFirstPartOfStr($path, GeneralUtility::getIndpEnv('TYPO3_SITE_URL'))) {
                $content = GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . $this->arguments['content'];
            }
        }
        if ($useNameAttribute && $this->arguments['property'] !== '') {
            $type = 'name';
            $content = $this->arguments['property'];
        }
        $this->getPageRenderer()->setMetaTag($type, $this->arguments['property'], $content);
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
