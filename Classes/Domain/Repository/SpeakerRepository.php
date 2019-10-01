<?php
declare(strict_types = 1);
namespace Evoweb\Sessionplaner\Domain\Repository;

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

class SpeakerRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * Default Orderings
     */
    protected $defaultOrderings = [
        'name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    ];

    public function findByDetailPage(int $pageId): \Evoweb\Sessionplaner\Domain\Model\Speaker
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('detailPage', $pageId));
        /** @var \Evoweb\Sessionplaner\Domain\Model\Speaker $result */
        $result = $query->execute()->getFirst();
        return $result;
    }
}
