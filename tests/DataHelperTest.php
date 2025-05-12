<?php

declare(strict_types=1);

namespace Seworqs\Commons\I18n\Test;

use PHPUnit\Framework\Attributes\Test;
use Seworqs\Commons\I18n\Helper\DataHelper;
use Seworqs\Commons\I18n\Enum\Common\EnumGender;
use Seworqs\Commons\I18n\Enum\FormatType\EnumBooleanFormatType;
use Seworqs\Commons\I18n\Enum\FormatType\EnumNumericFormatType;
use Seworqs\Commons\I18n\Test\TestCase\BaseTranslationTestCase;

final class DataHelperTest extends BaseTranslationTestCase
{
    #[Test]
    public function it_formats_gender_data(): void
    {
        $data = DataHelper::getGenderData(EnumGender::NON_BINARY, 'nl');

        $this->assertArrayHasKey('formatted', $data);
        $this->assertSame('x', $data['formatted']['key']);
        $this->assertSame('X', $data['formatted']['abbreviation']);
        $this->assertSame('Non-binair', $data['formatted']['text']);
    }

    #[Test]
    public function it_formats_boolean(): void
    {
        $label = DataHelper::translateBoolean(true, EnumBooleanFormatType::YES_NO, 'nl');
        $this->assertSame('Ja', $label);
    }

    #[Test]
    public function it_formats_numeric_data(): void
    {
        $data = DataHelper::getNumericData(1234.56, 'nl_NL', 2, 'EUR');

        $this->assertArrayHasKey('formatted', $data);
        $this->assertArrayHasKey(EnumNumericFormatType::CURRENCY->value, $data['formatted']);
        $this->assertNotEmpty($data['formatted'][EnumNumericFormatType::CURRENCY->value]);
    }
}
