<?php

declare(strict_types=1);

namespace Seworqs\Commons\I18n;

use Laminas\Translator\TranslatorInterface;

/**
 * Registry to store and retrieve
 * TranslatorInterface instances by key.
 */
final class TranslatorRegistry
{
    private const DEFAULT_KEY = 'default';

    private static array $instances = [];

    public static function register(string $key, TranslatorInterface $translator): void
    {
        self::$instances[$key] = $translator;
    }

    public static function getTranslator(string $key = null)
    {
        $key = $key ?? self::DEFAULT_KEY;

        if (!isset(self::$instances[$key])) {
            throw new \RuntimeException("Translator '{$key}' not found in registry.");
        }

        return self::$instances[$key];
    }

    public static function has(string $key): bool
    {
        return isset(self::$instances[$key]);
    }
}