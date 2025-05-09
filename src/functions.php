<?php
declare(strict_types=1);

use Seworqs\Commons\I18n\TranslatorRegistry;

/**
 * Formats a translated string safely with parameters.
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
    $translator = TranslatorRegistry::getTranslator();
    $translated = (string)$translator->translate($message, $textDomain, $locale);

    return safeSprintf($translated, $params);
}

/**
 * Plural translation, always injects the count as first %d.
 */
function t2(
    string      $singular,
    string      $plural,
    int         $number,
    array       $params     = [],
    string      $textDomain = 'default',
    ?string     $locale     = null
): string {
    $translator = TranslatorRegistry::getTranslator();
    $translated = (string)$translator->translatePlural(
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
 * Assumes your phpArray fixtures use keys like 'context|message'.
 */
function tc(
    string      $context,
    string      $message,
    array       $params     = [],
    ?string     $locale     = null
): string {
    $translator = TranslatorRegistry::getTranslator();
    $key        = $context . '|' . $message;
    $translated = (string)$translator->translate($key, 'context', $locale);

    return safeSprintf($translated, $params);
}
