<?php

declare(strict_types=1);

namespace Evoweb\Sessionplaner\DataProcessing;

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

use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use Evoweb\Sessionplaner\Domain\Model\Speaker;
use Evoweb\Sessionplaner\Domain\Repository\SpeakerRepository;

class SpeakerProcessor implements DataProcessorInterface
{
    protected SpeakerRepository $speakerRepository;

    public function __construct(SpeakerRepository $speakerRepository)
    {
        $this->speakerRepository = $speakerRepository;
    }

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
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        $speaker = $this->speakerRepository->findByDetailPage((int)$processedData['data']['uid']);

        if ($speaker instanceof Speaker) {
            $targetVariableName = $cObj->stdWrapValue('as', $processorConfiguration) ?: 'speaker';
            $processedData[$targetVariableName] = $speaker;
        }

        return $processedData;
    }
}
