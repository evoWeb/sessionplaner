<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Domain\Repository;

use Evoweb\Sessionplaner\Domain\Model\Day;
use Evoweb\Sessionplaner\Domain\Model\Session;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * @extends Repository<Session>
 */
class SessionRepository extends Repository
{
    /**
     * @var array<non-empty-string, 'ASC'|'DESC'>
     */
    protected $defaultOrderings = [
        'topic' => QueryInterface::ORDER_ASCENDING,
    ];

    public function findAnyByUid(int $uid): ?Session
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $query->getQuerySettings()->setIncludeDeleted(true);
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('uid', $uid));
        return $query->execute()->getFirst();
    }

    /**
     * @return QueryResultInterface<int, Session>
     */
    public function findSuggested(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching($query->equals('suggestion', 1));
        return $query->execute();
    }

    /**
     * @return QueryResultInterface<int, Session>
     */
    public function findByDayAndEmptySlot(Day $day): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('day', $day),
                $query->equals('slot', 0)
            )
        );
        return $query->execute();
    }

    /**
     * @return QueryResultInterface<int, Session>
     */
    public function findUnassignedSessions(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalOr(
                $query->equals('slot', 0),
                $query->equals('slot', null)
            )
        );
        return $query->execute();
    }

    /**
     * @return QueryResultInterface<int, Session>
     */
    public function findByDayAndHasSlotHasRoom(string $days): QueryResultInterface
    {
        $days = GeneralUtility::intExplode(',', $days, true);
        if ($days === []) {
            $days = [-1];
        }
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->in('day', $days),
                $query->logicalNot($query->equals('slot', 0)),
                $query->logicalNot($query->equals('room', 0))
            )
        );
        return $query->execute();
    }
}
