<?php

/*
 * This file is part of the package Evoweb\Sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\ViewHelpers;

class TitleTagViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @return void
     */
    public function render()
    {
        $content = trim($this->renderChildren());
        if (!empty($content)) {
            $this->getTypoScriptFrontendController()->page['title'] = $content;
            $this->getTypoScriptFrontendController()->indexedDocTitle = $content;
        }
    }

    /**
     * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }
}
