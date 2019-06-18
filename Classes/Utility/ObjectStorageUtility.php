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

namespace Evoweb\Sessionplaner\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class ObjectStorageUtility
{
    const SORT_ASCENDING = 'ASC';
    const SORT_DESCENDING = 'DESC';

    /**
     * @param ObjectStorage $objectStorage
     * @param string $property
     * @param string $order
     *
     * @return ObjectStorage
     */
    public static function sort($objectStorage, $property, $order = self::SORT_ASCENDING): ObjectStorage
    {
        $inventory = [];
        foreach ($objectStorage as $item) {
            $key = $item->_getProperty($property);
            $key.= '-';
            $key.= $item->_getProperty('uid');
            $inventory[$key] = $item;
        }

        if ($order === self::SORT_ASCENDING) {
            ksort($inventory);
        } else {
            krsort($inventory);
        }

        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $storage = $objectManager->get(ObjectStorage::class);
        foreach ($inventory as $item) {
            $storage->attach($item);
        }

        return $storage;
    }
}
