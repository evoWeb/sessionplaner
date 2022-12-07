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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;

class SuggestFormFinisher extends AbstractFinisher
{
    protected ?ConfigurationManagerInterface $configurationManager = null;

    protected ?SpeakerRepository $speakerRepository = null;

    protected ?SessionRepository $sessionRepository = null;

    protected ?PersistenceManagerInterface $persistenceManager = null;

    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    public function injectSpeakerRepository(SpeakerRepository $speakerRepository)
    {
        $this->speakerRepository = $speakerRepository;
    }

    public function injectSessionRepository(SessionRepository $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }

    public function injectPersistenceManager(PersistenceManagerInterface $persistenceManager)
    {
        $this->persistenceManager = $persistenceManager;
    }

    protected function executeInternal()
    {
        $settings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            'sessionplaner'
        );
        $storagePid = GeneralUtility::intExplode(',', $settings['persistence']['storagePid'])[0] ?? 0;

        $data = $this->finisherContext->getFormValues();

        $speaker = $this->speakerRepository->findOneByEmailIncludeHidden($data['email']);
        if (!$speaker) {
            $speaker = new Speaker();
            $speaker->initializeObject();
            $speaker->setPid($storagePid);
            $speaker->setHidden(true);
            $speaker->setName($data['fullname']);
            $speaker->setEmail($data['email']);
            $speaker->setTwitter($data['twitter']);
        }
        $session = new Session();
        $session->initializeObject();
        $session->setPid($storagePid);
        $session->setHidden(true);
        $session->setSuggestion(true);
        $session->setTopic($data['title']);
        $session->setDescription($data['description']);
        $session->setType($data['type']);
        $session->setLevel($data['level']);
        $session->addSpeaker($speaker);

        $this->sessionRepository->add($session);
        $this->persistenceManager->persistAll();
    }
}
