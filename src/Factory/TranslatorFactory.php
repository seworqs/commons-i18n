<?php

declare(strict_types=1);

namespace Seworqs\Commons\I18n\Factory;

use Psr\Container\ContainerInterface;
use Laminas\I18n\Translator\Translator as LaminasTranslator;
use Seworqs\Commons\I18n\CompositeTranslator;
use Seworqs\Commons\I18n\Translator;
use Seworqs\Commons\I18n\TranslatorRegistry;

/**
 * Factory for composing translators and applying fallback decorator.
 */
final class TranslatorFactory
{
    public function __invoke(ContainerInterface $container, $requestedName): Translator
    {
        $configMap = $container->get('config')['translator'] ?? [];
        $translator = self::createStandAlone($configMap);

        TranslatorRegistry::register($requestedName, $translator);
        return $translator;
    }

    public static function createStandAlone(array $translatorConfig = []): Translator
    {
        $locale       = $translatorConfig['locale'] ?? null;
        $fallback     = $translatorConfig['fallbackLocale'] ?? 'en';
        $patterns     = $translatorConfig['translation_file_patterns'] ?? [];

        $arrayPatterns   = array_filter($patterns, fn($p) => ($p['type'] ?? '') === 'phpArray');
        $gettextPatterns = array_filter($patterns, fn($p) => ($p['type'] ?? '') === 'gettext');

        $arrayTranslator = null;
        if (!empty($arrayPatterns)) {
            $cfg = ['locale' => $locale, 'fallbackLocale' => $fallback, 'translation_file_patterns' => $arrayPatterns];
            $arrayTranslator = LaminasTranslator::factory($cfg);
        }

        $gettextTranslator = null;
        if (!empty($gettextPatterns)) {
            $cfg = ['locale' => $locale, 'fallbackLocale' => $fallback, 'translation_file_patterns' => $gettextPatterns];
            $gettextTranslator = LaminasTranslator::factory($cfg);
        }

        $delegates = array_filter([$arrayTranslator, $gettextTranslator]);
        $composite = new CompositeTranslator($delegates);

        return new Translator($composite, $fallback);
    }

    public static function getTranslationFilePattern(): array
    {
        return [
            'type'     => 'gettext',
            'base_dir' => dirname(__DIR__, 4) . '/languages/messages',
            'pattern'  => '%s.mo',
        ];
    }
}