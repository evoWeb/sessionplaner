<?php
namespace Evoweb\Sessionplaner\ViewHelpers;

/*
 * This file is part of the package evoweb\sessionplaner.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

class TitleTagViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
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
