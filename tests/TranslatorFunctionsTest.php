<?php

declare(strict_types=1);

namespace Seworqs\Commons\I18n\Test;

use Seworqs\Commons\I18n\Test\TestCase\BaseTranslationTestCase;
use function Seworqs\Commons\I18n\Functions\{t, t2, tc};

final class TranslatorFunctionsTest extends BaseTranslationTestCase
{
    public function testSingleTranslation(): void
    {
        $this->assertSame('Hallo wereld', t('hello.world', [], 'test'));
    }

    public function testRegionFallback(): void
    {
        // nl_BE doe noit exist => fallback to nl
        $this->assertSame('Slechts in het Nederlands', t('only.nl', [], 'test'));
    }

    public function testFinalFallback(): void
    {
        // Key not in nl, fallback to en.
        $this->assertSame('Only in English', t('only.en', [], 'test'));
    }

    public function testPluralTranslation(): void
    {
        $this->assertSame('1 artikel', t2('item.singular', 'item.plural', 1, [], 'test'));
        $this->assertSame('5 artikelen', t2('item.singular', 'item.plural', 5, [], 'test'));
    }

    public function testContextTranslation(): void
    {
        $this->assertSame('Zomer', tc('season', 'summer'));
        $this->assertSame('Lente', tc('season', 'spring'));
    }

    public function testRegionFallbackExplicit(): void
    {
        $this->assertSame('Slechts in het Nederlands', t('only.nl', [], 'test', 'nl_BE'));
    }

    public function testFallbackToKeyIfMissing(): void
    {
        $this->assertSame('nonexistent.key', t('nonexistent.key', [], 'test', 'nl'));
    }

    public function testSafeSprintfFallback(): void
    {
        // Too few params for placeholders.
        $this->assertSame('Hallo %s %s. [!! FORMAT ERROR]', t('broken.placeholders', ['wereld'], 'test'));
    }
}
