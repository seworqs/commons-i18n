<?php

declare(strict_types=1);

namespace Seworqs\Commons\I18n\Functions;

use Seworqs\Commons\I18n\Registry\TranslatorRegistry;

/**
 * Safe formatting helper.
 */
function safeSprintf(string $message, array $params = []): string
{
    if (empty($params)) {
        return $message;
    }

    try {
        return vsprintf($message, $params);
    } catch (\Throwable $e) {
        return $message . ' [!! FORMAT ERROR]';
    }
}

/**
 * Single translation.
 */
function t(
    string      $message,
    array       $params     = [],
    string      $textDomain = 'default',
    ?string     $locale     = null
): string {
    $translated = TranslatorRegistry::getTranslator()->translate($message, $textDomain, $locale);
    return safeSprintf($translated, $params);
}

/**
 * Plural translation.
 */
function t2(
    string      $singular,
    string      $plural,
    int         $number,
    array       $params     = [],
    string      $textDomain = 'default',
    ?string     $locale     = null
): string {
    $translated = TranslatorRegistry::getTranslator()->translatePlural(
        $singular,
        $plural,
        $number,
        $textDomain,
        $locale
    );

    array_unshift($params, $number);
    return safeSprintf($translated, $params);
}

/**
 * Context-based translation.
 */
function tc(
    string      $context,
    string      $message,
    array       $params     = [],
    ?string     $locale     = null
): string {
    $key        = $context . '|' . $message;
    $translated = TranslatorRegistry::getTranslator()->translate($key, 'context', $locale);

    return safeSprintf($translated, $params);
}
