<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Domain\Repository;

use Evoweb\Sessionplaner\Domain\Model\Speaker;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class SpeakerRepository extends Repository
{
    /**
     * Default Orderings
     */
    protected $defaultOrderings = [
        'name' => QueryInterface::ORDER_ASCENDING
    ];

    public function findByDetailPage(int $pageId): ?Speaker
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('detailPage', $pageId));
        /** @var Speaker $result */
        $result = $query->execute()->getFirst();
        return $result;
    }

    public function findOneByEmailIncludeHidden(string $email): ?Speaker
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $query->matching($query->equals('email', trim($email)));

        /** @var Speaker $speaker */
        $speaker = $query->execute()->getFirst();
        return $speaker;
    }
}
