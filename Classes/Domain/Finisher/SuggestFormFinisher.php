<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Domain\Finisher;

use Evoweb\Sessionplaner\Domain\Model\Session;
use Evoweb\Sessionplaner\Domain\Model\Speaker;
use Evoweb\Sessionplaner\Domain\Repository\SessionRepository;
use Evoweb\Sessionplaner\Domain\Repository\SpeakerRepository;
use Evoweb\Sessionplaner\Domain\Repository\TagRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;

class SuggestFormFinisher extends AbstractFinisher
{
    protected ?ConfigurationManagerInterface $configurationManager = null;

    protected ?SpeakerRepository $speakerRepository = null;

    protected ?SessionRepository $sessionRepository = null;

    protected ?TagRepository $tagRepository = null;

    protected ?PersistenceManagerInterface $persistenceManager = null;

    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager): void
    {
        $this->configurationManager = $configurationManager;
    }

    public function injectSpeakerRepository(SpeakerRepository $speakerRepository): void
    {
        $this->speakerRepository = $speakerRepository;
    }

    public function injectSessionRepository(SessionRepository $sessionRepository): void
    {
        $this->sessionRepository = $sessionRepository;
    }

    public function injectTagRepository(TagRepository $tagRepository): void
    {
        $this->tagRepository = $tagRepository;
    }

    public function injectPersistenceManager(PersistenceManagerInterface $persistenceManager): void
    {
        $this->persistenceManager = $persistenceManager;
    }

    protected function executeInternal()
    {
        if ($this->configurationManager === null
            || $this->speakerRepository === null
            || $this->sessionRepository === null
            || $this->tagRepository === null
            || $this->persistenceManager === null
        ) {
            return null;
        }

        $settings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            'sessionplaner'
        );

        $storagePid = 0;
        if (isset($settings['persistence']['storagePid'])) {
            $exploded = GeneralUtility::intExplode(',', (string)$settings['persistence']['storagePid']);
            $storagePid = max(0, ($exploded[0] ?? 0));
        }

        $data = $this->finisherContext->getFormValues();

        $speaker = $this->speakerRepository->findOneByEmailIncludeHidden($data['email'] ?? '');

        if ($speaker === null) {
            $speaker = new Speaker();
            $speaker->initializeObject();
            $speaker->setPid($storagePid);
            $speaker->setName((string)($data['fullname'] ?? ''));
            $speaker->setEmail((string)($data['email'] ?? ''));
            if (isset($data['twitter']) && $data['twitter'] !== '') {
                $speaker->setTwitter((string)$data['twitter']);
            }
        }

        $session = new Session();
        $session->initializeObject();
        $session->setPid($storagePid);
        $session->setHidden(true);
        $session->setSuggestion(true);

        if (isset($data['requesttype']) && $data['requesttype'] !== '') {
            $session->setRequesttype((int)$data['requesttype']);
        }

        $session->setTopic((string)($data['title'] ?? ''));
        $session->setDescription((string)($data['description'] ?? ''));

        if (isset($data['type']) && $data['type'] !== '') {
            $session->setType((int)$data['type']);
        }

        if (isset($data['tag']) && $data['tag'] !== '') {
            $tag = $this->tagRepository->findByUid((int)$data['tag']);
            if ($tag !== null) {
                $session->addTag($tag);
            }
        }

        if (isset($data['level']) && $data['level'] !== '') {
            $session->setLevel((int)$data['level']);
        }

        $session->addSpeaker($speaker);

        if (isset($data['norecording']) && $data['norecording'] !== '') {
            $session->setNorecording((bool)$data['norecording']);
        }

        $this->sessionRepository->add($session);
        $this->persistenceManager->persistAll();

        return null;
    }
}
