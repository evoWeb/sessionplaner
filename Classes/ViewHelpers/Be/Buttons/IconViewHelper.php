<?php
namespace Evoweb\Sessionplaner\ViewHelpers\Be\Buttons;

use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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
class IconViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper
{
    /**
     * Initialize arguments.
     */
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
     * Renders an icon link as known from the TYPO3 backend
     *
     * @return string the rendered icon link
     */
    public function render()
    {
        return static::renderStatic(
            $this->arguments,
            $this->buildRenderChildrenClosure(),
            $this->renderingContext
        );
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

        $iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);
        $allowedIcons = $iconRegistry->getAllRegisteredIconIdentifiers();

        if (!in_array($iconKey, $allowedIcons)) {
            throw new \TYPO3Fluid\Fluid\Core\ViewHelper\Exception(
                '"' . $iconKey . '" is no valid icon. Allowed are "' . implode('", "', $allowedIcons) . '".',
                1253208523
            );
        } else {
            /** @var \TYPO3\CMS\Core\Imaging\IconFactory $iconFactory */
            $iconFactory = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconFactory::class);
            $icon = $iconFactory->getIcon($iconKey, \TYPO3\CMS\Core\Imaging\Icon::SIZE_SMALL);
        }

        if (empty($uri) && empty($onclick)) {
            return $icon;
        } else {
            $onclick = ' onclick="' . $onclick . '"';
            return '<a href="' . $uri . '"
                title="' . $title . '"
                class="' . $class . '"
                id="' . $id . '" ' . $onclick . '>' . $icon . '</a>';
        }
    }
}
