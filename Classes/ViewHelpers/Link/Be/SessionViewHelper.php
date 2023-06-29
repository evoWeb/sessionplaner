<?php
declare(strict_types = 1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\ViewHelpers\Link\Be;

use Evoweb\Sessionplaner\Domain\Model\Session;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class SessionViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'a';

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('target', 'string', 'Target of link');
        $this->registerTagAttribute('itemprop', 'string', 'itemprop attribute');
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document');

        $this->registerArgument('session', Session::class, 'The session to link to', true);
        $this->registerArgument('returnUri', 'bool', 'return only uri', false, false);
    }

    public function render(): string
    {
        $request = $this->getRequest();
        if (!$request instanceof ServerRequestInterface) {
            throw new \RuntimeException(
                'ViewHelper sessionplanervh:link.be.session needs a request implementing ServerRequestInterface.',
                1684305290
            );
        }

        /** @var Session $session */
        $session = $this->arguments['session'];
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);

        $params = [
            'edit' => ['tx_sessionplaner_domain_model_session' => [$session->getUid() => 'edit']],
            'returnUrl' => $request->getAttribute('normalizedParams')->getRequestUri(),
        ];
        $uri = (string)$uriBuilder->buildUriFromRoute('record_edit', $params);
        if (isset($this->arguments['returnUri']) && $this->arguments['returnUri'] === true) {
            return htmlspecialchars($uri, ENT_QUOTES | ENT_HTML5);
        }

        $linkText = $this->renderChildren() ?? $session->getTopic();
        $this->tag->addAttribute('href', $uri);
        $this->tag->setContent($linkText);

        return $this->tag->render();
    }

    protected function getRequest(): ?ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'] ?? null;
    }
}
