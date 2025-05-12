<?php

declare(strict_types=1);

namespace Seworqs\Commons\I18n\Helper;

use NumberFormatter;
use Seworqs\Commons\I18n\Enum\Common\EnumGender;
use Seworqs\Commons\I18n\Enum\FormatType\EnumBooleanFormatType;
use Seworqs\Commons\I18n\Enum\FormatType\EnumNumericFormatType;
use function Seworqs\Commons\I18n\Functions\t;
use function Seworqs\Commons\I18n\Functions\tc;

class DataHelper
{
    public static function getBooleanData(bool $boolean, ?string $locale = null): array
    {
        return [
            'raw' => $boolean,
            'formatted' => [
                EnumBooleanFormatType::YES_NO->value          => $boolean ? t('formatting.boolean.yes', [], 'enum', $locale) : t('formatting.boolean.no', [], 'enum', $locale),
                EnumBooleanFormatType::TRUE_FALSE->value      => $boolean ? t('formatting.boolean.true', [], 'enum', $locale) : t('formatting.boolean.false', [], 'enum', $locale),
                EnumBooleanFormatType::ON_OFF->value          => $boolean ? t('formatting.boolean.on', [], 'enum', $locale) : t('formatting.boolean.off', [], 'enum', $locale),
                EnumBooleanFormatType::RIGHT_WRONG->value     => $boolean ? t('formatting.boolean.right', [], 'enum', $locale) : t('formatting.boolean.wrong', [], 'enum', $locale),
                EnumBooleanFormatType::ACTIVE_INACTIVE->value => $boolean ? t('formatting.boolean.active', [], 'enum', $locale) : t('formatting.boolean.inactive', [], 'enum', $locale),
                EnumBooleanFormatType::BINAIR->value          => $boolean ? t('formatting.boolean.1', [], 'enum', $locale) : t('formatting.boolean.0', [], 'enum', $locale),
            ]
        ];
    }

    public static function translateBoolean(bool $boolean, EnumBooleanFormatType $formatType, ?string $locale = null): string
    {
        $formats = self::getBooleanData($boolean, $locale);
        return $formats['formatted'][$formatType->value] ?? '';
    }

    public static function getNumericData(
        int|float $number,
        string $locale = 'en_US',
        int $fractionDigits = 2,
        string $currencyCode = 'USD'
    ): array {
        $nf = new NumberFormatter($locale, NumberFormatter::DECIMAL);
        $nf->setAttribute(NumberFormatter::FRACTION_DIGITS, $fractionDigits);

        $cf = new NumberFormatter($locale . '@currency=' . $currencyCode, NumberFormatter::CURRENCY);
        $cf->setAttribute(NumberFormatter::FRACTION_DIGITS, $fractionDigits);

        return [
            'raw' => $number,
            'formatted' => [
                EnumNumericFormatType::NUMERIC->value         => $nf->format($number),
                EnumNumericFormatType::CURRENCY->value        => $cf->formatCurrency($number, $currencyCode),
                EnumNumericFormatType::CURRENCY_CODE->value   => $currencyCode,
                EnumNumericFormatType::CURRENCY_SYMBOL->value => $cf->getSymbol(NumberFormatter::CURRENCY_SYMBOL),
            ]
        ];
    }

    public static function getGenderData(EnumGender $gender, ?string $locale = null): array
    {
        return [
            'formatted' => [
                'key'          => t('formatting.gender.key.' . $gender->value, [], 'enum', $locale),
                'abbreviation' => t('formatting.gender.abbreviation.' . $gender->value, [], 'enum', $locale),
                'text'         => t('formatting.gender.text.' . $gender->value, [], 'enum', $locale),
            ]
        ];
    }
}
