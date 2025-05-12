<?php

namespace Seworqs\Commons\I18n\Enum\Common;

use Seworqs\Commons\I18n\Contract\TranslatableEnumInterface;
use Seworqs\Commons\I18n\Traits\TranslatableEnumTrait;

enum EnumGender: string implements TranslatableEnumInterface
{
    use TranslatableEnumTrait;

    case MALE = 'male';
    case FEMALE = 'female';
    case NON_BINARY = 'non_binary';
    case OTHER = 'other';
    case UNKNOWN = 'unknown';

    public static function getTranslationPrefix(): string
    {
        return 'enum.gender';
    }

    public static function getTextDomain(): string
    {
        return 'enum';
    }
}
