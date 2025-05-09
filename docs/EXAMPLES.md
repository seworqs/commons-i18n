# Examples

## Install via Composer
```bash
composer require seworqs/commons-i18n
```

## Basic Usage (stand alone)

### Create and register the Translator.
```php
use Seworqs\Commons\I18n\Factory\TranslatorFactory;
use Seworqs\Commons\I18n\TranslatorRegistry;

// You can also use .mo files for type=gettext.
$config = [
    'locale'                   => 'nl_NL',
    'fallbackLocale'           => 'en',
    'translation_file_patterns'=> [
        [
            'type'     => 'phpArray',
            'base_dir' => __DIR__ . '/language/messages',
            'pattern'  => '%s.php',
        ],
    ],
];

$translator = TranslatorFactory::createStandAlone($config);
TranslatorRegistry::register('default', $translator);
```

### Translate via helper functions.
```php
// Single translation.
echo t('greeting.hello');

// Plural translation with count injection.
echo t2('item.one', 'item.many', 3); 

// Context based translation.
echo tc('errors', ' not_found');

// Some more options (params).
echo t('Hi %s, you have %d items', ['SEworqs',5]);

// Some more options (params, text domain).
echo t('Hi %s, you have %d items', ['SEworqs',5], 'SomeTextDomain');

// Some more options (params, text domain, locale).
echo t('Hi %s, you have %d items', ['SEworqs',5], 'SomeTextDomain', 'en_US');

```

