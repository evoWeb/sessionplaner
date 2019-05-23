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

class SessionRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * Default Orderings
     */
    protected $defaultOrderings = [
        'topic' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    ];

    /**
     * @return array|\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
     */
    public function findSuggested()
    {
        $query = $this->createQuery();

        $query->matching(
            $query->logicalAnd(
                [
                    $query->equals('suggestion', 1)
                ]
            )
        );

        return $query->execute();
    }

    /**
     * @param \Evoweb\Sessionplaner\Domain\Model\Day $day
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
     */
    public function findByDay($day)
    {
        $query = $this->createQuery();

        $query->matching(
            $query->equals('day', $day)
        );

        return $query->execute();
    }

    /**
     * @param \Evoweb\Sessionplaner\Domain\Model\Day $day
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
     */
    public function findByDayAndEmptySlot($day)
    {
        $query = $this->createQuery();

        $query->matching(
            $query->logicalAnd(
                [
                    $query->equals('day', $day),
                    $query->equals('slot', 0)
                ]
            )
        );

        return $query->execute();
    }

    /**
     * @param string $days
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult|null
     */
    public function findByDayAndHasSlotHasRoom($days)
    {
        $days = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $days);
        if (is_array($days) && count($days) > 0) {
            $query = $this->createQuery();

            $result = $query->matching(
                $query->logicalAnd(
                    [
                        $query->in('day', $days),
                        $query->logicalNot($query->equals('slot', 0)),
                        $query->logicalNot($query->equals('room', 0))
                    ]
                )
            )->execute();
        } else {
            $result = null;
        }
        return $result;
    }
}
