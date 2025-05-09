<?php

declare(strict_types=1);

namespace Seworqs\Commons\I18n;

use Laminas\Translator\TranslatorInterface;
use Traversable;

/**
 * Composite translator that sequentially tries multiple backends.
 */
final class CompositeTranslator implements TranslatorInterface
{
    /** @param TranslatorInterface[] $delegates */
    public function __construct(
        private readonly array $delegates
    ) {}

    public function translate($message, $textDomain = 'default', $locale = null): string
    {
        foreach ($this->delegates as $translator) {
            $translated = $translator->translate($message, $textDomain, $locale);
            if ($translated !== $message) {
                return $translated;
            }
        }
        return (string) $message;
    }

    public function translatePlural($singular, $plural, $number, $textDomain = 'default', $locale = null): string
    {
        $key = $number === 1 ? $singular : $plural;
        foreach ($this->delegates as $translator) {
            $translated = $translator->translatePlural(
                $singular, $plural, $number, $textDomain, $locale
            );
            if ($translated !== $key) {
                return $translated;
            }
        }
        return $key;
    }

    /**
     * Return raw messages for a domain & locale.
     * Delegates to the first backend supporting it.
     *
     * @param string $textDomain
     * @param string|null $locale
     * @return array<string,string>|Traversable
     */
    public function getAllMessages($textDomain = 'default', $locale = null): array|Traversable
    {
        $locale = $locale ?? $this->getLocale();
        foreach ($this->delegates as $translator) {
            if (method_exists($translator, 'getAllMessages')) {
                $messages = $translator->getAllMessages($textDomain, $locale);
                if (is_array($messages) || $messages instanceof Traversable) {
                    return $messages;
                }
            }
        }
        return [];
    }

    public function getLocale(): string
    {
        return $this->delegates[0]->getLocale();
    }

    public function setLocale(string $locale): void
    {
        foreach ($this->delegates as $translator) {
            $translator->setLocale($locale);
        }
    }

    public function getFallbackLocale(): ?string
    {
        foreach ($this->delegates as $translator) {
            if (method_exists($translator, 'getFallbackLocale')) {
                return $translator->getFallbackLocale();
            }
        }
        return null;
    }

    public function setFallbackLocale(string $locale): void
    {
        foreach ($this->delegates as $translator) {
            if (method_exists($translator, 'setFallbackLocale')) {
                $translator->setFallbackLocale($locale);
            }
        }
    }
}