<?php

declare(strict_types=1);

namespace Evoweb\Sessionplaner\ViewHelpers\Be\Menus;

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
        $uri = $uriBuilder->reset()->uriFor($action, $arguments, $controller);
        $this->tag->addAttribute('value', $uri);
        if ($this->isSelected($controller, $action, $arguments, $current, $currentArgumentKey)) {
            $this->tag->addAttribute('selected', 'selected');
        }
        $this->tag->setContent($label);
        return $this->tag->render();
    }

    public function isSelected(
        string $controller,
        string $action,
        array $arguments,
        string $current,
        string $currentArgumentKey
    ): bool {
        if ($current === '' && $currentArgumentKey === '') {
            $currentRequest = $this->renderingContext->getControllerContext()->getRequest();
            $currentController = $currentRequest->getControllerName();
            $currentAction = $currentRequest->getControllerActionName();

            $result = ($action === $currentAction && $controller === $currentController);
        } else {
            $result = ($current == $arguments[$currentArgumentKey]);
        }

        return $result;
    }
}
