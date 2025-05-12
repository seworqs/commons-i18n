<?php

namespace Seworqs\Commons\I18n\Enum\FormatType;

use Seworqs\Commons\I18n\Contract\TranslatableEnumInterface;
use Seworqs\Commons\I18n\Traits\TranslatableEnumTrait;

enum EnumBooleanFormatType: string implements TranslatableEnumInterface
{
    use TranslatableEnumTrait;

    case ACCEPTED_REJECTED   = 'accepted_rejected';
    case ACTIVE_INACTIVE     = 'active_inactive';
    case BINAIR              = 'binair';
    case CHECK_UNCHECK       = 'check_uncheck';
    case ENABLED_DISABLED    = 'enabled_disabled';
    case GRANTED_DENIED      = 'granted_denied';
    case OK_NOK              = 'ok_nok';
    case ON_OFF              = 'on_off';
    case POSITIVE_NEGATIVE   = 'positive_negative';
    case RIGHT_WRONG         = 'right_wrong';
    case SUCCESS_FAIL        = 'success_fail';
    case TRUE_FALSE          = 'true_false';
    case VISIBLE_HIDDEN      = 'visible_hidden';
    case YES_NO              = 'yes_no';

    public static function getTranslationPrefix(): string
    {
        return 'enum.format_type.boolean';
    }

    public static function getTextDomain(): string
    {
        return 'enum';
    }
}
