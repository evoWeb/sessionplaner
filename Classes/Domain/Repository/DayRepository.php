<?php
namespace Evoweb\Sessionplaner\Domain\Repository;

/*
 * This file is part of the package evoweb\sessionplaner.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

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
     * @return array
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
