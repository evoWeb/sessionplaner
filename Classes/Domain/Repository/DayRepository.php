<?php

declare(strict_types=1);

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class DayRepository extends Repository
{
    /**
     * Default Orderings
     */
    protected $defaultOrderings = [
        'date' => QueryInterface::ORDER_ASCENDING
    ];

    public function findByUidList(string $uidList): QueryResultInterface
    {
        $uids = GeneralUtility::intExplode(',', $uidList, true);
        if (empty($uids)) {
            $uids = [-1];
        }
        $query = $this->createQuery();
        return $query->matching(
            $query->logicalAnd(
                $query->in('uid', $uids)
            )
        )->execute();
    }
}
