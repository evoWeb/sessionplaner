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
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;

#[Autoconfigure(public: true)]
class SuggestFormFinisher extends AbstractFinisher
{
    public function __construct(
        protected readonly ConfigurationManagerInterface $configurationManager,
        protected readonly SpeakerRepository $speakerRepository,
        protected readonly SessionRepository $sessionRepository,
        protected readonly TagRepository $tagRepository,
        protected readonly PersistenceManagerInterface $persistenceManager,
    ) {}

    protected function executeInternal(): null
    {
        $settings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            'sessionplaner'
        );

        $storagePid = $this->getStoragePid($settings);

        $data = $this->finisherContext->getFormValues();

        $session = $this->createSession($storagePid, $data);

        $this->sessionRepository->add($session);
        $this->persistenceManager->persistAll();

        return null;
    }

    /**
     * @return int<0, max>
     */
    public function getStoragePid(array $settings): int
    {
        $storagePid = 0;
        if (isset($settings['persistence']['storagePid'])) {
            $exploded = GeneralUtility::intExplode(',', (string)$settings['persistence']['storagePid']);
            $storagePid = (int)max(0, ($exploded[0] ?? 0));
        }
        return $storagePid;
    }

    /**
     * @param int<0, max> $storagePid
     */
    public function createSession(int $storagePid, array $data): Session
    {
        $session = new Session();
        $session->setPid($storagePid);
        $session->setHidden(true);
        $session->setSuggestion(true);

        $session->setTopic((string)($data['title'] ?? ''));
        $session->setDescription((string)($data['description'] ?? ''));

        if (($data['requesttype'] ?? '') !== '') {
            $session->setRequesttype((int)$data['requesttype']);
        }

        if (($data['type'] ?? '') !== '') {
            $session->setType((int)$data['type']);
        }

        if (($data['length'] ?? '') !== '') {
            $session->setLength((int)$data['length']);
        }

        if (($data['level'] ?? '') !== '') {
            $session->setLevel((int)$data['level']);
        }

        if (($data['norecording'] ?? '') !== '') {
            $session->setNorecording((bool)$data['norecording']);
        }

        if (($data['tag'] ?? '') !== '') {
            $tag = $this->tagRepository->findByUid((int)$data['tag']);
            if ($tag !== null) {
                $session->addTag($tag);
            }
        }

        $speaker = $this->getSpeaker($data, $storagePid);
        $session->addSpeaker($speaker);

        return $session;
    }

    /**
     * @param int<0, max> $storagePid
     */
    public function getSpeaker(array $data, int $storagePid): Speaker
    {
        $speaker = $this->speakerRepository->findOneByEmailIncludeHidden($data['email'] ?? '');
        if ($speaker === null) {
            $speaker = new Speaker();
            $speaker->setPid($storagePid);
            $speaker->setName((string)($data['fullname'] ?? ''));
            $speaker->setEmail((string)($data['email'] ?? ''));
            if (($data['twitter'] ?? '') !== '') {
                $speaker->setTwitter((string)$data['twitter']);
            }
        }
        return $speaker;
    }
}
