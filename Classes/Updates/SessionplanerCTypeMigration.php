<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Evoweb\Sessionplaner\Updates;

use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate;

/**
 * @internal This class is only meant to be used within EXT:install.
 */
// @phpstan-ignore attribute.deprecated
#[UpgradeWizard(SessionplanerCTypeMigration::class)]
// @phpstan-ignore class.extendsDeprecatedClass
final class SessionplanerCTypeMigration extends AbstractListTypeToCTypeUpdate
{
    protected function getListTypeToCTypeMapping(): array
    {
        return [
            'sessionplaner_session' => 'sessionplaner_session',
            'sessionplaner_sessionplan' => 'sessionplaner_sessionplan',
            'sessionplaner_speaker' => 'sessionplaner_speaker',
            'sessionplaner_suggest' => 'sessionplaner_suggest',
            'sessionplaner_tag' => 'sessionplaner_tag',
        ];
    }

    public function getTitle(): string
    {
        return 'Migrate "Sessionplaner" plugins to content elements.';
    }

    public function getDescription(): string
    {
        return '
            The "Sessionplaner" plugins are now registered as content elements.
            Update migrates existing records and backend user permissions.
        ';
    }
}
