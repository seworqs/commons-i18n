<?php

declare(strict_types=1);

namespace Seworqs\Commons\I18n\Test;

use PHPUnit\Framework\Attributes\Test;
use Seworqs\Commons\I18n\Enum\Common\EnumGender;
use Seworqs\Commons\I18n\Enum\FormatType\EnumBooleanFormatType;
use Seworqs\Commons\I18n\Test\TestCase\BaseTranslationTestCase;

final class TranslatableEnumTest extends BaseTranslationTestCase
{
    #[Test]
    public function it_translates_enum_gender(): void
    {
        $this->assertSame('Man', EnumGender::MALE->getTranslatedString(locale: 'sv'));
        $this->assertSame('Kvinna', EnumGender::FEMALE->getTranslatedString(locale: 'sv'));
    }

    #[Test]
    public function it_returns_options_array_for_boolean_format(): void
    {
        $options = EnumBooleanFormatType::toOptionsArray();
        $this->assertArrayHasKey('yes_no', $options);
        $this->assertSame('Ja/Nee', $options['yes_no']);
    }
}
