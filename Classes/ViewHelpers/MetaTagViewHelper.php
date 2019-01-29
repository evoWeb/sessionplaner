<?php
namespace Evoweb\Sessionplaner\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013-2019 Benjamin Kott <info@bk2k.info>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

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
