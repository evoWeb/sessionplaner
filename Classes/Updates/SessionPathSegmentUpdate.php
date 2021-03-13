<?php

declare(strict_types=1);

namespace Evoweb\Sessionplaner\Updates;

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

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * SessionPathSegmentUpdate
 */
class SessionPathSegmentUpdate implements UpgradeWizardInterface
{
    protected string $table = 'tx_sessionplaner_domain_model_session';

    protected string $slugField = 'path_segment';

    public function getIdentifier(): string
    {
        return self::class;
    }

    public function getTitle(): string
    {
        return '[EXT:sessionplaner] Generate Path-Segments for Sessions';
    }

    public function getDescription(): string
    {
        return '';
    }

    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class
        ];
    }

    public function updateNecessary(): bool
    {
        /** @var DeletedRestriction $deleteRestriction */
        $deleteRestriction = GeneralUtility::makeInstance(DeletedRestriction::class);
        $queryBuilder = $this->getQueryBuilderForTable($this->table);
        $queryBuilder->getRestrictions()->removeAll()->add($deleteRestriction);

        $elementCount = $queryBuilder
            ->count('uid')
            ->from($this->table)
            ->where(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq($this->slugField, $queryBuilder->createNamedParameter('')),
                    $queryBuilder->expr()->isNull($this->slugField)
                )
            )
            ->execute()
            ->fetchOne();

        return (bool)$elementCount;
    }

    public function executeUpdate(): bool
    {
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($this->table);
        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        $statement = $queryBuilder
            ->select('*')
            ->from($this->table)
            ->where(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq($this->slugField, $queryBuilder->createNamedParameter('')),
                    $queryBuilder->expr()->isNull($this->slugField)
                )
            )
            ->execute();

        $fieldConfig = $GLOBALS['TCA'][$this->table]['columns'][$this->slugField]['config'];
        $evalInfo = !empty($fieldConfig['eval']) ? GeneralUtility::trimExplode(',', $fieldConfig['eval'], true) : [];
        $hasToBeUniqueInSite = in_array('uniqueInSite', $evalInfo, true);
        $hasToBeUniqueInPid = in_array('uniqueInPid', $evalInfo, true);
        $slugHelper = GeneralUtility::makeInstance(SlugHelper::class, $this->table, $this->slugField, $fieldConfig);

        while ($record = $statement->fetch()) {
            $recordId = (int)$record['uid'];
            $pid = (int)$record['pid'];

            // Build Slug
            $slug = $slugHelper->generate($record, $pid);
            $state = RecordStateFactory::forName($this->table)->fromArray($record, $pid, $recordId);
            if ($hasToBeUniqueInSite && !$slugHelper->isUniqueInSite($slug, $state)) {
                $slug = $slugHelper->buildSlugForUniqueInSite($slug, $state);
            }
            if ($hasToBeUniqueInPid && !$slugHelper->isUniqueInPid($slug, $state)) {
                $slug = $slugHelper->buildSlugForUniqueInPid($slug, $state);
            }

            // Update Record
            $queryBuilder = $connection->createQueryBuilder();
            $queryBuilder
                ->update($this->table)
                ->where(
                    $queryBuilder->expr()->eq(
                        'uid',
                        $queryBuilder->createNamedParameter($record['uid'], \PDO::PARAM_INT)
                    )
                )
                ->set($this->slugField, $slug);
            $queryBuilder->execute();
        }

        return true;
    }

    protected function getQueryBuilderForTable(string $table): QueryBuilder
    {
        /** @var ConnectionPool $pool */
        $pool = GeneralUtility::makeInstance(ConnectionPool::class);
        return $pool->getQueryBuilderForTable($table);
    }
}
