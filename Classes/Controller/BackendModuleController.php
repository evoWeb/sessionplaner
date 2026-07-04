<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Controller;

use Evoweb\Sessionplaner\Constants;
use Evoweb\Sessionplaner\Domain\Model\Day;
use Evoweb\Sessionplaner\Domain\Repository\DayRepository;
use Evoweb\Sessionplaner\Domain\Repository\SessionRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Routing\Route;
use TYPO3\CMS\Backend\Routing\UriBuilder as BackendUriBuilder;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\Components\Buttons\LinkButton;
use TYPO3\CMS\Backend\Template\Components\Menu\Menu;
use TYPO3\CMS\Backend\Template\Components\Menu\MenuItem;
use TYPO3\CMS\Backend\Template\Components\MenuRegistry;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Imaging\IconSize;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

class BackendModuleController extends ActionController
{
    protected int $pageId = 0;
    protected ?Day $currentDay = null;

    public function __construct(
        protected readonly DayRepository $dayRepository,
        protected readonly SessionRepository $sessionRepository,
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        protected readonly IconFactory $iconFactory,
        protected readonly PageRenderer $pageRenderer,
        protected readonly BackendUriBuilder $backendUriBuilder,
    ) {}

    protected function initializeAction(): void
    {
        $this->pageRenderer->loadJavaScriptModule('@evoweb/sessionplaner/backend/sessionplaner.js');
        $this->pageRenderer->addCssFile('EXT:sessionplaner/Resources/Public/Stylesheets/backend.css');
    }

    public function showAction(): ResponseInterface
    {
        $parsedBody = $this->request->getParsedBody();
        if (!is_array($parsedBody)) {
            $parsedBody = [];
        }
        $queryParams = $this->request->getQueryParams();
        $this->pageId = (int)($parsedBody['id'] ?? $queryParams['id'] ?? 0);

        $day = (int)($parsedBody['day'] ?? $queryParams['day'] ?? 0);
        if ($day !== 0) {
            $this->currentDay = $this->dayRepository->findByUid($day);
        } else {
            /** @var QueryResultInterface<int, Day> $allDays */
            $allDays = $this->dayRepository->findAll();
            $this->currentDay = $allDays->getFirst();
        }

        $days = $this->dayRepository->findAll();
        $view = $this->moduleTemplateFactory->create($this->request);
        $view->assignMultiple([
            'currentDay' => $this->currentDay,
            'days' => $days,
            'unassignedSessions' => $this->sessionRepository->findUnassignedSessions(),
            'returnUri' => $this->createModuleUri(),
        ]);

        $title = 'Sessionplaner';
        if ($this->currentDay !== null) {
            $title .= ' ' . $this->currentDay->getName();
        }
        $view->setTitle($title);

        $page = BackendUtility::getRecord('pages', $this->pageId);
        if ($page !== null && isset($page['doktype']) && (int)$page['doktype'] === Constants::STORAGE_FOLDER_TYPE) {
            $docHeaderComponent = $view->getDocHeaderComponent();
            $this->registerMenuDays($docHeaderComponent->getMenuRegistry());
            $this->registerButtonNewSession($docHeaderComponent->getButtonBar());
            $this->registerButtonNewSpeaker($docHeaderComponent->getButtonBar());
            $this->registerButtonNewRoom($docHeaderComponent->getButtonBar());
            $this->registerButtonNewDay($docHeaderComponent->getButtonBar());
        }

        return $view->renderResponse('BackendModule/Show');
    }

    protected function registerMenuDays(MenuRegistry $menuRegistry): void
    {
        /** @var QueryResultInterface<int, Day> $days */
        $days = $this->dayRepository->findAll();
        if ($days->count() > 0) {
            $actionMenu = GeneralUtility::makeInstance(Menu::class);
            $actionMenu->setIdentifier('actionMenu');
            $actionMenu->setLabel('');
            foreach ($days as $day) {
                $title = $day->getDate()->format('d.m.y') . ' - ' . $day->getName();
                $actionMenu->addMenuItem(
                    GeneralUtility::makeInstance(MenuItem::class)
                        ->setTitle($title)
                        ->setHref($this->createModuleUri(['day' => (string)$day->getUid()]))
                        ->setActive(($this->currentDay === $day))
                );
            }
            $menuRegistry->addMenu($actionMenu);
        }
    }

    protected function registerButtonNewSession(ButtonBar $buttonBar): void
    {
        $this->addButtonToButtonBar($buttonBar, 'tx_sessionplaner_domain_model_session', 'session-new', 1);
    }

    protected function registerButtonNewSpeaker(ButtonBar $buttonBar): void
    {
        $this->addButtonToButtonBar($buttonBar, 'tx_sessionplaner_domain_model_speaker', 'speaker-new', 2);
    }

    protected function registerButtonNewRoom(ButtonBar $buttonBar): void
    {
        $this->addButtonToButtonBar($buttonBar, 'tx_sessionplaner_domain_model_room', 'room-new', 3);
    }

    protected function registerButtonNewDay(ButtonBar $buttonBar): void
    {
        $this->addButtonToButtonBar($buttonBar, 'tx_sessionplaner_domain_model_day', 'day-new', 4);
    }

    protected function addButtonToButtonBar(
        ButtonBar $buttonBar,
        string $table,
        string $labelKey,
        int $buttonGroup
    ): void {
        $parameters = [
            'edit' => [$table => [$this->pageId => 'new']],
            'returnUrl' => $this->createModuleUri(),
        ];
        $button = GeneralUtility::makeInstance(LinkButton::class)
            ->setHref((string)$this->backendUriBuilder->buildUriFromRoute('record_edit', $parameters))
            ->setTitle(
                $this->getLanguageService()?->sL(
                    'LLL:EXT:sessionplaner/Resources/Private/Language/locallang.xlf:' . $labelKey
                ) ?? $labelKey
            )
            ->setShowLabelText(true)
            ->setIcon($this->iconFactory->getIcon('actions-plus', IconSize::SMALL));
        $buttonBar->addButton($button, ButtonBar::BUTTON_POSITION_LEFT, $buttonGroup);
    }

    /**
     * @param array<string, string> $params
     */
    public function createModuleUri(array $params = []): string
    {
        $request = $this->request;
        $route = $request->getAttribute('route');
        if (!$route instanceof Route) {
            return '';
        }

        $baseParams = [
            'id' => (string)$this->pageId,
            'day' => (string)$this->currentDay?->getUid(),
        ];

        $params = array_replace_recursive($baseParams, $params);
        $params = array_filter($params, static fn($value) => $value !== null && trim((string)$value) !== '');

        $routeName = is_string($route->getOption('_identifier')) ? $route->getOption('_identifier') : '';
        return (string)$this->backendUriBuilder->buildUriFromRoute($routeName, $params);
    }

    protected function getLanguageService(): ?LanguageService
    {
        return $GLOBALS['LANG'] instanceof LanguageService ? $GLOBALS['LANG'] : null;
    }
}
