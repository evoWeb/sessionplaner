<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Domain\Model;

use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException;

abstract class AbstractSlugEntity extends AbstractEntity
{
    protected string $slugField;
    protected string $tablename;

    public function _isNew(): bool
    {
        $isNew = parent::_isNew();
        if ($isNew) {
            if ($this->slugField === '') {
                throw new NoSuchArgumentException('The property "slugField" can not be empty', 1559731500);
            }

            $slugSetter = 'set' . GeneralUtility::underscoredToUpperCamelCase($this->slugField);
            if (!method_exists($this, $slugSetter)) {
                throw new NoSuchArgumentException(
                    'The method "' . $slugSetter . '" must exist in your entity',
                    1559731501
                );
            }

            if ($this->tablename === '') {
                throw new NoSuchArgumentException('The property "tablename" can not be empty', 1559731502);
            }

            $pid = $this->getPid();
            if ($pid === null || $pid === 0) {
                throw new NoSuchArgumentException('The property "pid" can not be empty', 1559731503);
            }

            $this->{$slugSetter}($this->generateSlug());
        }

        return $isNew;
    }

    public function generateSlug(): string
    {
        $properties = $this->_getProperties();
        $record = [];

        $tca = is_array($GLOBALS['TCA'] ?? null) ? $GLOBALS['TCA'] : [];
        $tca = is_array($tca[$this->tablename] ?? null) ? $tca[$this->tablename] : [];
        $columns = is_array($tca['columns'] ?? null) ? $tca['columns'] : [];
        $column = is_array($columns[$this->slugField] ?? null) ? $columns[$this->slugField] : [];
        $fieldConfig = is_array($column['config'] ?? null) ? $column['config'] : [];
        $evalInfo = is_string($fieldConfig['eval'] ?? null) && $fieldConfig['eval'] !== ''
            ? GeneralUtility::trimExplode(',', $fieldConfig['eval'], true)
            : [];

        $hasToBeUniqueInSite = in_array('uniqueInSite', $evalInfo, true);
        $hasToBeUniqueInPid = in_array('uniqueInPid', $evalInfo, true);
        /** @var SlugHelper $slugHelper */
        $slugHelper = GeneralUtility::makeInstance(
            SlugHelper::class,
            $this->tablename,
            $this->slugField,
            $fieldConfig
        );

        foreach ($properties as $k => $v) {
            $field = GeneralUtility::camelCaseToLowerCaseUnderscored($k);
            $v = is_object($v) && method_exists($v, 'getUid') ? $v->getUid() : $v;
            $record[$field] = $v;
        }

        $pid = (int)($record['pid'] ?? 0);
        $slug = $slugHelper->generate($record, $pid);

        $state = RecordStateFactory::forName($this->tablename)->fromArray($record, $pid, 'NEW');

        if ($hasToBeUniqueInSite && !$slugHelper->isUniqueInSite($slug, $state)) {
            $slug = $slugHelper->buildSlugForUniqueInSite($slug, $state);
        }

        if ($hasToBeUniqueInPid && !$slugHelper->isUniqueInPid($slug, $state)) {
            $slug = $slugHelper->buildSlugForUniqueInPid($slug, $state);
        }

        return $slug;
    }
}
