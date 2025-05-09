<?php

declare(strict_types=1);

namespace Seworqs\Commons\I18n;

use Laminas\Translator\TranslatorInterface;
use Traversable;

/**
 * Decorator around any TranslatorInterface instance,
 * providing multi-step fallback:
 *  1) region → language   (e.g. nl_BE → nl)
 *  2) final fallback      (e.g. nl → en)
 */
final class Translator implements TranslatorInterface
{
    public function __construct(
        private readonly TranslatorInterface $inner,
        private readonly string              $finalFallback = 'en',
    ) {
        // Let Laminas handle its built-in fallback (nl → en)
        if (method_exists($inner, 'setFallbackLocale')) {
            $inner->setFallbackLocale($this->finalFallback);
        }
    }

    /**
     * Translate a message key, with region→language→final fallback.
     *
     * @param mixed       $message    Message key or literal
     * @param mixed       $textDomain Text domain (default 'default')
     * @param mixed|null  $locale     Locale override
     * @return string                 Translated string or original key
     */
    public function translate($message, $textDomain = 'default', $locale = null): string
    {
        $locale     = $locale ?? $this->inner->getLocale();
        $candidates = [$locale];

        if (is_string($locale) && str_contains($locale, '_')) {
            [$lang] = explode('_', $locale, 2);
            $candidates[] = $lang;
        }
        $candidates[] = $this->finalFallback;

        foreach ($candidates as $loc) {
            // Safely fetch raw messages, default to empty
            $messages = [];
            if (method_exists($this->inner, 'getAllMessages')) {
                $tmp = $this->inner->getAllMessages($textDomain, $loc);
                if (is_array($tmp) || $tmp instanceof Traversable) {
                    $messages = $tmp;
                }
            }
            $map = is_array($messages) ? $messages : iterator_to_array($messages);

            if (array_key_exists($message, $map) || $loc === $this->finalFallback) {
                return (string) $this->inner->translate($message, $textDomain, $loc);
            }
        }

        return (string) $message;
    }

    /**
     * Translate plural forms, injecting the matching pattern key
     * and relying on vsprintf in the caller.
     *
     * @param string      $singular   Singular key
     * @param string      $plural     Plural key
     * @param int         $number     Number to determine form
     * @param mixed       $textDomain Text domain
     * @param mixed|null  $locale     Locale override
     * @return string                 Translated pattern (e.g. '%d artikelen')
     */
    public function translatePlural($singular, $plural, $number, $textDomain = 'default', $locale = null): string
    {
        $locale     = $locale ?? $this->inner->getLocale();
        $candidates = [$locale];

        if (is_string($locale) && str_contains($locale, '_')) {
            [$lang] = explode('_', $locale, 2);
            $candidates[] = $lang;
        }
        $candidates[] = $this->finalFallback;

        foreach ($candidates as $loc) {
            $messages = [];
            if (method_exists($this->inner, 'getAllMessages')) {
                $tmp = $this->inner->getAllMessages($textDomain, $loc);
                if (is_array($tmp) || $tmp instanceof Traversable) {
                    $messages = $tmp;
                }
            }
            $map = is_array($messages) ? $messages : iterator_to_array($messages);

            $key = $number === 1 ? $singular : $plural;
            if (array_key_exists($key, $map) || $loc === $this->finalFallback) {
                return (string) $this->inner->translate($key, $textDomain, $loc);
            }
        }

        return $number === 1 ? $singular : $plural;
    }

    public function getLocale(): string
    {
        return $this->inner->getLocale();
    }

    public function setLocale($locale): void
    {
        $this->inner->setLocale($locale);
    }

    public function getFallbackLocale(): ?string
    {
        if (method_exists($this->inner, 'getFallbackLocale')) {
            return $this->inner->getFallbackLocale();
        }
        return null;
    }

    public function setFallbackLocale($locale): void
    {
        if (method_exists($this->inner, 'setFallbackLocale')) {
            $this->inner->setFallbackLocale($locale);
        }
    }
}