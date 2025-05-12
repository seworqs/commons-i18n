<?php

namespace Seworqs\Commons\I18n\Enum\FormatType;

use Seworqs\Commons\I18n\Contract\TranslatableEnumInterface;
use Seworqs\Commons\I18n\Traits\TranslatableEnumTrait;

enum EnumNumericFormatType: string implements TranslatableEnumInterface
{
    use TranslatableEnumTrait;

    case NUMERIC = 'numeric';
    case CURRENCY = 'currency';
    case CURRENCY_CODE = 'currency_code';
    case CURRENCY_SYMBOL = 'currency_symbol';

    public static function getTranslationPrefix(): string
    {
        return 'enum.format_type.numeric';
    }

    public static function getTextDomain(): string
    {
        return 'enum';
    }
}
