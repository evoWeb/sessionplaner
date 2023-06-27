<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class DayRepository extends Repository
{
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
