<?php

namespace Seworqs\Commons\I18n\Traits;

use Seworqs\Commons\I18n\Registry\TranslatorRegistry;
use Seworqs\Commons\I18n\Contract\TranslatableEnumInterface;

trait TranslatableEnumTrait
{
    public function getValue(): string
    {
        return $this->value;
    }

    public function getTranslationKey(): string
    {
        return static::getTranslationPrefix() . '.' . $this->value;
    }

    public function getTranslatedString(?string $textDomain = null, ?string $locale = null): string
    {
        return TranslatorRegistry::getTranslator()->translate(
            $this->getTranslationKey(),
            $textDomain ?? static::getTextDomain(),
            $locale
        );
    }

    public static function toOptionsArray(?string $textDomain = null, ?string $locale = null): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->getValue()] = $case->getTranslatedString($textDomain, $locale);
        }
        return $options;
    }

    public static function toLabelValueArray(?string $textDomain = null, ?string $locale = null): array
    {
        return array_map(fn(self $case) => [
            'value' => $case->getValue(),
            'label' => $case->getTranslatedString($textDomain, $locale),
        ], self::cases());
    }
}
