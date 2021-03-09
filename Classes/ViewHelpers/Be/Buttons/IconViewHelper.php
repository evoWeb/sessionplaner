<?php

declare(strict_types=1);

namespace Evoweb\Sessionplaner\ViewHelpers\Be\Buttons;

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

use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

/**
 * View helper which returns save button with icon
 * Note: This view helper is experimental!
 *
 * = Examples =
 *
 * <code title="Default">
 * <f:be.buttons.icon uri="{f:uri.action()}" />
 * </code>
 *
 * Output:
 * An icon button as known from the TYPO3 backend, skinned and linked with the
 * default action of the current controller. Note: By default the "close" icon
 * is used as image
 *
 * <code title="Default">
 * <f:be.buttons.icon uri="{f:uri.action(action='new')}"
 * icon="new_el" title="Create new Foo" />
 * </code>
 *
 * Output:
 * This time the "new_el" icon is returned, the button has the title attribute
 * set and links to the "new" action of the current controller.
 */
class IconViewHelper extends AbstractBackendViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument(
            'uri',
            'string',
            'The URI for the link. If you want to execute JavaScript here, prefix with "javascript:"',
            true
        );
        $this->registerArgument(
            'iconKey',
            'string',
            'Icon to be used. See IconRegistry::icons for a list of allowed icon names',
            false,
            'actions-close'
        );
        $this->registerArgument(
            'title',
            'string',
            'Title attribute of the resulting link'
        );
        $this->registerArgument(
            'onclick',
            'string',
            'Javascript action taken if clicked'
        );
        $this->registerArgument('id', 'string', '');
        $this->registerArgument('class', 'string', '');
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $uri = $arguments['uri'];
        $title = $arguments['title'];
        $iconKey = $arguments['iconKey'];
        $onclick = $arguments['onclick'];
        $id = $arguments['id'];
        $class = $arguments['class'];

        /** @var IconRegistry $iconRegistry */
        $iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);
        $allowedIcons = $iconRegistry->getAllRegisteredIconIdentifiers();

        if (!in_array($iconKey, $allowedIcons)) {
            throw new Exception(
                '"' . $iconKey . '" is no valid icon. Allowed are "' . implode('", "', $allowedIcons) . '".',
                1253208523
            );
        }
        /** @var \TYPO3\CMS\Core\Imaging\IconFactory $iconFactory */
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $icon = $iconFactory->getIcon($iconKey, Icon::SIZE_SMALL);

        if (empty($uri) && empty($onclick)) {
            return $icon;
        }
        $onclick = ' onclick="' . $onclick . '"';
        return implode(' ', [
                '<a href="' . $uri . '"',
                'title="' . $title . '"',
                'class="' . $class . '"',
                'id="' . $id . '"',
                $onclick . '>' . $icon . '</a>'
            ]);
    }
}
