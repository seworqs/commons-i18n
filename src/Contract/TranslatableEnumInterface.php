<?php

namespace Seworqs\Commons\I18n\Contract;

interface TranslatableEnumInterface
{
    public function getTranslatedString(?string $textDomain = null, ?string $locale = null): string;

    public function getValue(): string;

    public function getTranslationKey(): string;

    public static function getTranslationPrefix(): string;

    public static function getTextDomain(): string;
}
