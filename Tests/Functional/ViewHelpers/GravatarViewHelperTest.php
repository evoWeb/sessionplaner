<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Tests\Functional\ViewHelpers;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextFactory;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3Fluid\Fluid\View\TemplateView;

final class GravatarViewHelperTest extends FunctionalTestCase
{
    /**
     * md5('speaker@example.org'), the hash gravatar answers this address under.
     */
    private const HASH = 'd8eb0378685c08b366be05093eb652e9';
    protected bool $initializeDatabase = false;

    #[Test]
    public function renderUsesTheRequestedSizeInsteadOfTheDefault(): void
    {
        // Regression: the size argument was read with is_string() while being
        // registered as int, so every avatar was requested at the 80px default.
        $result = $this->render('<sp:gravatar email="speaker@example.org" size="240" />');

        self::assertStringContainsString('?s=240&amp;', $result);
        self::assertStringContainsString('width="240"', $result);
        self::assertStringContainsString('height="240"', $result);
        self::assertStringNotContainsString('s=80', $result);
    }

    #[Test]
    public function renderOffersTheDoubledSizeAsRetinaCandidate(): void
    {
        $result = $this->render('<sp:gravatar email="speaker@example.org" size="240" />');

        self::assertStringContainsString(
            'srcset="https://www.gravatar.com/avatar/' . self::HASH . '?s=240&amp;d=mm&amp;r=g 1x,'
            . ' https://www.gravatar.com/avatar/' . self::HASH . '?s=480&amp;d=mm&amp;r=g 2x"',
            $result
        );
    }

    #[Test]
    public function renderClampsBothCandidatesToTheGravatarMaximum(): void
    {
        $result = $this->render('<sp:gravatar email="speaker@example.org" size="4096" />');

        self::assertStringContainsString('?s=2048&amp;', $result);
        self::assertStringContainsString('width="2048"', $result);
        self::assertStringNotContainsString('s=4096', $result);
        // At the maximum there is no larger candidate left, so no srcset is written.
        self::assertStringNotContainsString('srcset', $result);
    }

    public static function sizeFallsBackToTheDefaultDataProvider(): array
    {
        return [
            'no size argument' => ['<sp:gravatar email="speaker@example.org" />'],
            'empty size variable' => ['<sp:gravatar email="speaker@example.org" size="{size}" />'],
            'zero' => ['<sp:gravatar email="speaker@example.org" size="0" />'],
            'negative size' => ['<sp:gravatar email="speaker@example.org" size="-10" />'],
        ];
    }

    /**
     * Fluid casts an empty value to 0 on an int argument, so a size that never
     * arrived has to render at the registered default rather than at one pixel.
     */
    #[Test]
    #[DataProvider('sizeFallsBackToTheDefaultDataProvider')]
    public function renderFallsBackToTheDefaultSizeForAnUnusableSize(string $template): void
    {
        $result = $this->render($template, ['size' => '']);

        self::assertStringContainsString('?s=80&amp;', $result);
        self::assertStringContainsString('width="80"', $result);
        self::assertStringContainsString('height="80"', $result);
    }

    public static function emailIsNormalisedBeforeHashingDataProvider(): array
    {
        return [
            'plain address' => ['speaker@example.org'],
            'upper case address' => ['Speaker@Example.ORG'],
            'address surrounded by whitespace' => ['  speaker@example.org  '],
        ];
    }

    /**
     * Gravatar hashes the trimmed and lowercased address; without normalising,
     * the two variants below resolve to an avatar that does not exist.
     */
    #[Test]
    #[DataProvider('emailIsNormalisedBeforeHashingDataProvider')]
    public function renderNormalisesTheEmailBeforeHashing(string $email): void
    {
        $result = $this->render('<sp:gravatar email="{email}" />', ['email' => $email]);

        self::assertStringContainsString('https://www.gravatar.com/avatar/' . self::HASH . '?', $result);
    }

    #[Test]
    public function renderPassesDefaultAndRatingIntoTheUrl(): void
    {
        $result = $this->render(
            '<sp:gravatar email="speaker@example.org" default="identicon" rating="pg" />'
        );

        self::assertStringContainsString('d=identicon', $result);
        self::assertStringContainsString('r=pg', $result);
    }

    /**
     * @param array<string, mixed> $variables
     */
    private function render(string $template, array $variables = []): string
    {
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource(
            '<html xmlns:sp="http://typo3.org/ns/Evoweb/Sessionplaner/ViewHelpers"'
            . ' data-namespace-typo3-fluid="true">' . $template . '</html>'
        );
        $view = new TemplateView($context);
        $view->assignMultiple($variables);

        return trim($view->render());
    }
}
