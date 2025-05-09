<?php

declare(strict_types=1);

namespace Seworqs\Commons\I18n\Test;

use PHPUnit\Framework\TestCase;
use Seworqs\Commons\I18n\Factory\TranslatorFactory;
use Seworqs\Commons\I18n\TranslatorRegistry;

/**
 * Integration tests for global translation functions:
 *   - t(): single-string translation
 *   - t2(): plural translation
 *   - tc(): context-based translation
 *
 * Verifies region->language and final locale fallbacks.
 */
final class TranslatorFunctionsTest extends TestCase
{
    protected function setUp(): void
    {
        // Create and register a standalone Translator
        $translator = TranslatorFactory::createStandAlone([
            'locale'                   => 'nl_BE',
            'fallbackLocale'           => 'en',
            'translation_file_patterns'=> [
                [
                    'type'     => 'phpArray',
                    'base_dir' => __DIR__ . '/resources/language/messages',
                    'pattern'  => '%s.php',
                ],
                [
                    'type'        => 'phpArray',
                    'base_dir'    => __DIR__ . '/resources/language/context',
                    'pattern'     => '%s.php',
                    'text_domain' => 'context',
                ],
            ],
        ]);

        TranslatorRegistry::register('default', $translator);
    }

    public function testSingleTranslation(): void
    {
        // Defined in nl.php as 'Hallo wereld'
        $this->assertSame('Hallo wereld', t('hello.world'));
    }

    public function testRegionFallback(): void
    {
        // nl_BE has no key, falls back to nl.php
        $this->assertSame('Slechts in het Nederlands', t('only.nl'));
    }

    public function testFinalFallback(): void
    {
        // Only in en.php
        $this->assertSame('Only in English', t('only.en'));
    }

    public function testPluralTranslation(): void
    {
        $one   = t2('item.singular', 'item.plural', 1);
        $many  = t2('item.singular', 'item.plural', 5);

        $this->assertSame('1 artikel', $one);
        $this->assertSame('5 artikelen', $many);
    }

    public function testContextTranslation(): void
    {
        // Uses 'context' domain
        $summer = tc('season', 'summer');
        $spring = tc('season', 'spring');

        $this->assertSame('Zomer', $summer);
        $this->assertSame('Lente', $spring);
    }
}

// Fixture files under:
// tests/TranslatorFunctionsTest/resources/languages/messages/nl.php
// tests/TranslatorFunctionsTest/resources/languages/messages/en.php
// tests/TranslatorFunctionsTest/resources/languages/context/nl.php
// tests/TranslatorFunctionsTest/resources/languages/context/en.php

// Example messages/nl.php:
// <?php return [
//     'hello.world'  => 'Hallo wereld',
//     'only.nl'      => 'Slechts in het Nederlands',
//     'item.singular'=> '%d artikel',
//     'item.plural'  => '%d artikelen',
// ];

// Example messages/en.php:
// <?php return [
//     'hello.world'  => 'Hello world',
//     'only.en'      => 'Only in English',
//     'item.singular'=> '%d item',
//     'item.plural'  => '%d items',
// ];

// Example context/nl.php:
// <?php return [
//     'season|summer' => 'Zomer',
//     'season|spring' => 'Lente',
// ];

// Example context/en.php:
// <?php return [
//     'season|summer' => 'Summer',
//     'season|spring' => 'Spring',
// ];
