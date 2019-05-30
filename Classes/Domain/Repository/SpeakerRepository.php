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

namespace Evoweb\Sessionplaner\Domain\Repository;

class SpeakerRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * Default Orderings
     */
    protected $defaultOrderings = [
        'name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    ];

    /**
     * @param int $pageId
     * @return object
     */
    public function findByDetailPage($pageId)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('detailPage', $pageId));
        return $query->execute()->getFirst();
    }
}
