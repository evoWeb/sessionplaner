<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\DataProcessing;

use Evoweb\Sessionplaner\Domain\Model\Speaker;
use Evoweb\Sessionplaner\Domain\Repository\SpeakerRepository;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

#[Autoconfigure(public: true)]
class SpeakerProcessor implements DataProcessorInterface
{
    public function __construct(protected SpeakerRepository $speakerRepository) {}

    /**
     * Add this data processor if you want to have the Speaker object available
     * in your FLUID templates when the current page is set as a detail page of
     * a speaker.
     *
     * 1559226337 = Evoweb\Sessionplaner\DataProcessing\SpeakerProcessor
     * 1559226337 {
     *     as = speaker
     * }
     * @param array<string, string> $contentObjectConfiguration
     * @param array<string, string> $processorConfiguration
     * @param array<string, array<string, int>> $processedData
     * @return array<string, array<string, int>|Speaker>
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        $speaker = $this->speakerRepository->findByDetailPage((int)$processedData['data']['uid']);

        if ($speaker instanceof Speaker) {
            $targetVariableName = (string)$cObj->stdWrapValue('as', $processorConfiguration, 'speaker');
            $processedData[$targetVariableName] = $speaker;
        }

        return $processedData;
    }
}
