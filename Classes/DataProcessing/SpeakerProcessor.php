<?php

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

namespace Evoweb\Sessionplaner\DataProcessing;

use Evoweb\Sessionplaner\Domain\Model\Speaker;
use Evoweb\Sessionplaner\Domain\Repository\SpeakerRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class SpeakerProcessor implements \TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface
{
    /**
     * Add this data processor if you want to have the Speaker object available
     * in your FLUID templates when the current page is set as a detail page of
     * a speaker.
     *
     * 1559226337 = Evoweb\Sessionplaner\DataProcessing\SpeakerProcessor
     * 1559226337 {
     *     as = speaker
     * }
     *
     * @param \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $cObj
     * @param array $contentObjectConfiguration
     * @param array $processorConfiguration
     * @param array $processedData
     * @return array
     */
    public function process(
        \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $speakerRepository = $objectManager->get(SpeakerRepository::class);
        $speaker = $speakerRepository->findByDetailPage((int)$processedData['data']['uid']);

        if ($speaker instanceof Speaker) {
            $targetVariableName = $cObj->stdWrapValue('as', $processorConfiguration) ?: 'speaker';
            $processedData[$targetVariableName] = $speaker;
        }

        return $processedData;
    }

}
