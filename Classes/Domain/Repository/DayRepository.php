<?php

/*
 * This file is part of the package Evoweb\Sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Domain\Repository;

class DayRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * Default Orderings
     */
    protected $defaultOrderings = [
        'date' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    ];

    /**
     * @param string $uids
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
     */
    public function findByUidsRaw($uids)
    {
        $uids = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $uids);
        if (is_array($uids) && count($uids) > 0) {
            $query = $this->createQuery();
            $result = $query->matching(
                $query->logicalAnd(
                    $query->in('uid', $uids)
                )
            )->execute(true);
        } else {
            $result = null;
        }
        return $result;
    }
}
