<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\ViewHelpers\Be\Menus;

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Fluid\ViewHelpers\Be\Menus\ActionMenuItemViewHelper as FluidActionMenuItemViewHelper;

/**
 * View helper which returns an option tag.
 * This view helper only works in conjunction with \TYPO3\CMS\Fluid\ViewHelpers\Be\Menus\ActionMenuViewHelper
 * Note: This view helper is experimental!
 *
 * = Examples =
 *
 * <code title="Simple">
 * <f:be.menus.actionMenu>
 * <f:be.menus.actionMenuItem label="Overview" controller="Blog" action="index" />
 * <f:be.menus.actionMenuItem label="Create new Blog" controller="Blog" action="new" />
 * <f:be.menus.actionMenuItem label="List Posts" controller="Post" action="index" arguments="{blog: blog}" />
 * </f:be.menus.actionMenu>
 * </code>
 * <output>
 * Select element with the options "Overview", "Create new Blog" and "List Posts"
 * </output>
 *
 * <code title="Localized">
 * <f:be.menus.actionMenu>
 * <f:be.menus.actionMenuItem label="{f:translate(key='overview')}" controller="Blog" action="index" />
 * <f:be.menus.actionMenuItem label="{f:translate(key='create_blog')}" controller="Blog" action="new" />
 * </f:be.menus.actionMenu>
 * </code>
 * <output>
 * localized select element
 * <output>
 */
class ActionMenuItemViewHelper extends FluidActionMenuItemViewHelper
{
    /**
     * @var \TYPO3\CMS\Fluid\Core\Rendering\RenderingContext
     */
    protected $renderingContext;

    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('current', 'string', 'Current value');
        $this->registerArgument('currentArgumentKey', 'string', 'Key for current value in $arguments');
    }

    /**
     * Renders an ActionMenu option tag
     *
     * @return string the rendered option tag
     * @see \TYPO3\CMS\Fluid\ViewHelpers\Be\Menus\ActionMenuViewHelper
     */
    public function render()
    {
        $label = $this->arguments['label'];
        $controller = $this->arguments['controller'];
        $action = $this->arguments['action'];
        $arguments = $this->arguments['arguments'];

        $current = $this->arguments['current'];
        $currentArgumentKey = $this->arguments['currentArgumentKey'];

        $uriBuilder = $this->renderingContext->getControllerContext()->getUriBuilder();
        $uriBuilder->setRequest($this->renderingContext->getRequest());

        $uri = $uriBuilder->reset()->uriFor($action, $arguments, $controller);
        $this->tag->addAttribute('value', $uri);

        if (!$this->tag->hasAttribute('selected')) {
            $this->isSelected($controller, $action, $arguments, $current, $currentArgumentKey);
        }

        $this->tag->setContent(
            // Double encode can be set to true, once the typo3fluid/fluid fix is released and required
            htmlspecialchars($label, ENT_QUOTES, null, false)
        );
        return $this->tag->render();
    }

    public function isSelected(
        string $controller,
        string $action,
        array $arguments,
        int $current,
        string $currentArgumentKey
    ) {
        $result = false;
        if ($current === '' && $currentArgumentKey === '') {
            $currentRequest = $this->renderingContext->getRequest();
            $flatRequestArguments = ArrayUtility::flatten(
                array_merge([
                    'controller' => $currentRequest->getControllerName(),
                    'action' => $currentRequest->getControllerActionName()
                ], $currentRequest->getArguments())
            );
            $flatViewHelperArguments = ArrayUtility::flatten(
                array_merge(['controller' => $controller, 'action' => $action], $arguments)
            );
            if (
                $this->arguments['selected'] ||
                array_diff($flatRequestArguments, $flatViewHelperArguments) === []
            ) {
                $result = true;
            }
        } else {
            $result = ($current == $arguments[$currentArgumentKey]);
        }

        if ($result) {
            $this->tag->addAttribute('selected', 'selected');
        }
    }
}
