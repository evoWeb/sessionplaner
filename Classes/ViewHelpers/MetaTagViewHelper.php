<?php
namespace Evoweb\Sessionplaner\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Benjamin Kott <info@bk2k.info>
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
     * @param boolean $useCurrentDomain
     * @param boolean $forceAbsoluteUrl
     * @param boolean $useNameAttribute
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
