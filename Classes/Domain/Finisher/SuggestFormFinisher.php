<?php
declare(strict_types = 1);

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
    protected function executeInternal()
    {
        $configurationManager = $this->objectManager->get(ConfigurationManagerInterface::class);
        $settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK, 'sessionplaner');
        $storagePid = GeneralUtility::intExplode(',', $settings['persistence']['storagePid'])[0] ?? 0;
        $sessionRepository = $this->objectManager->get(SessionRepository::class);
        $speakerRepository = $this->objectManager->get(SpeakerRepository::class);
        $persistenceManager = $this->objectManager->get(PersistenceManagerInterface::class);

        $data = $this->finisherContext->getFormValues();
        $speaker = $speakerRepository->findOneByEmailIncludeHidden($data['email']);
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

        $sessionRepository->add($session);
        $persistenceManager->persistAll();
    }
}
