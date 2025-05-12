<?php

declare(strict_types=1);

namespace Seworqs\Commons\I18n\Test\TestCase;

use PHPUnit\Framework\TestCase;
use Seworqs\Commons\I18n\Factory\TranslatorFactory;
use Seworqs\Commons\I18n\Registry\TranslatorRegistry;

/**
 * Base test class for loading full translation configuration.
 * Includes:
 * - actual application translations (default domain)
 * - test-specific translation fixtures (domain: test)
 * - context-based fixtures for tc() tests (domain: context)
 */
abstract class BaseTranslationTestCase extends TestCase
{
    protected function setUp(): void
    {
        if (!TranslatorRegistry::has('default')) {
            $translator = TranslatorFactory::createStandAlone([
                'fallbackLocale' => 'en',
                'translation_file_patterns' => [
                    // Test-specific strings for t() and t2()
                    [
                        'type'        => 'phpArray',
                        'base_dir'    => __DIR__ . '/../resources/language/messages',
                        'pattern'     => '%s.php',
                        'text_domain' => 'test',
                    ],
                    // Context-based test fixtures for tc()
                    [
                        'type'        => 'phpArray',
                        'base_dir'    => __DIR__ . '/../resources/language/context',
                        'pattern'     => '%s.php',
                        'text_domain' => 'context',
                    ],
                ],
            ]);
            $translator->setLocale('nl_NL');
            TranslatorRegistry::register('default', $translator);
        }
    }
}
