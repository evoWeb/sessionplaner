<?php
declare(strict_types = 1);

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

namespace Evoweb\Sessionplaner\Domain\Model;

use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException;

abstract class AbstractSlugEntity extends AbstractEntity
{
    /**
     * @var string The name of the path segment field
     */
    protected $slugField;

    /**
     * @var string the tablename for this model
     */
    protected $tablename;

    /**
     * @throws NoSuchArgumentException
     *
     * @return bool
     */
    public function _isNew(): bool
    {
        $isNew = parent::_isNew();
        if ($isNew) {
            if (empty($this->slugField)) {
                throw new NoSuchArgumentException('The property "slugField" can not be empty', 1559731500);
            }
            $slugSetter = 'set' . GeneralUtility::underscoredToUpperCamelCase($this->slugField);
            if (!method_exists($this, $slugSetter)) {
                throw new NoSuchArgumentException(
                    'The method "' . $slugSetter . '" must exist in your entity',
                    1559731501
                );
            }
            if (empty($this->tablename)) {
                throw new NoSuchArgumentException('The property "tablename" can not be empty', 1559731502);
            }
            if (!$this->getPid()) {
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

        $fieldConfig = $GLOBALS['TCA'][$this->tablename]['columns'][$this->slugField]['config'];
        $evalInfo = !empty($fieldConfig['eval']) ? GeneralUtility::trimExplode(',', $fieldConfig['eval'], true) : [];
        $hasToBeUniqueInSite = in_array('uniqueInSite', $evalInfo, true);
        $hasToBeUniqueInPid = in_array('uniqueInPid', $evalInfo, true);
        $slugHelper = GeneralUtility::makeInstance(SlugHelper::class, $this->tablename, $this->slugField, $fieldConfig);

        foreach ($properties as $k => $v) {
            $field = GeneralUtility::camelCaseToLowerCaseUnderscored($k);
            $v = \is_object($v) && \method_exists($v, 'getUid') ? $v->getUid() :  $v;
            $record[$field] = $v;
        }

        $pid = (int)$record['pid'];
        $slug = $slugHelper->generate($record, $this->getPid());
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
