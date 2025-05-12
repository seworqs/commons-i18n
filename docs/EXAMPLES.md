# Examples

## Install via Composer

```bash
composer require seworqs/commons-i18n
```

## Basic Setup (Standalone)

```php
use Seworqs\Commons\I18n\Factory\TranslatorFactory;
use Seworqs\Commons\I18n\Registry\TranslatorRegistry;

$translator = TranslatorFactory::createStandAlone([
    'locale' => 'nl_NL',
    'fallbackLocale' => 'en'
]);

TranslatorRegistry::register('default', $translator);
```

## Translation Helpers

```php
use function Seworqs\Commons\I18n\t;
use function Seworqs\Commons\I18n\t2;
use function Seworqs\Commons\I18n\tc;

// Single translation
echo t('greeting.hello');

// Plural translation with count injection
echo t2('item.one', 'item.many', 3);

// Context-based translation
echo tc('errors', 'not_found');

// With parameters
echo t('Hi %s, you have %d items', ['SEworqs', 5]);

// With text domain
echo t('Hi %s, you have %d items', ['SEworqs', 5], 'custom');

// With locale override
echo t('Hi %s, you have %d items', ['SEworqs', 5], 'custom', 'en_US');
```

## Using Built-in Translatable Enums

```php
use Seworqs\Commons\I18n\Enum\Common\EnumGender;

$gender = EnumGender::MALE;
echo $gender->getTranslatedString();
```

```php
use Seworqs\Commons\I18n\Enum\FormatType\EnumBooleanFormatType;

$options = EnumBooleanFormatType::toOptionsArray();
// ['yes_no' => 'Yes / No', ...]
```

## Create Your Own Translatable Enums

```php
use Seworqs\Commons\I18n\Contract\TranslatableEnumInterface;
use Seworqs\Commons\I18n\Traits\TranslatableEnumTrait;

enum MyStatus: string implements TranslatableEnumInterface
{
    use TranslatableEnumTrait;

    case PENDING = 'pending';
    case DONE    = 'done';

    public static function getTranslationPrefix(): string
    {
        return 'enum.status';
    }

    public static function getTextDomain(): string
    {
        return 'enum';
    }
}
```

And provide language files like:

```php
return [
    'enum.status.pending' => 'Pending',
    'enum.status.done' => 'Done',
];
```
