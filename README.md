# Seworqs Commons i18n

A lightweight, standalone internationalization module for PHP 8.1+ that integrates both PHP‑array and Gettext back‑ends with advanced locale fallback logic and PSR‑11 compatibility. Includes support for translatable enums and global translation helpers.

## Installation

```bash
composer require seworqs/commons-i18n
```

## Usage

```php
use Seworqs\Commons\I18n\Factory\TranslatorFactory;
use Seworqs\Commons\I18n\Registry\TranslatorRegistry;

$translator = TranslatorFactory::createStandAlone([
    'locale' => 'nl_BE',
    'fallbackLocale' => 'en',
    'translation_file_patterns' => [
        ['type' => 'phpArray', 'base_dir' => 'path/to/language', 'pattern' => '%s.php'],
        ['type' => 'gettext', 'base_dir' => 'path/to/language', 'pattern' => '%s.mo'],
    ],
]);

TranslatorRegistry::register('default', $translator);

// Use helpers
use function Seworqs\Commons\I18n\t;
use function Seworqs\Commons\I18n\t2;
use function Seworqs\Commons\I18n\tc;

echo t('welcome.message');
echo t2('item.one', 'item.many', 5);
echo tc('errors', 'not_found');
```

## Creating Your Own Translatable Enums

You can define your own enum like this:

```php
use Seworqs\Commons\I18n\Contract\TranslatableEnumInterface;
use Seworqs\Commons\I18n\Traits\TranslatableEnumTrait;

enum Status: string implements TranslatableEnumInterface
{
    use TranslatableEnumTrait;

    case APPROVED = 'approved';
    case DECLINED = 'declined';

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

## Features

* [x] Combine multiple translation back-ends (PHP-array, Gettext) into a single composite translator
* [x] Implement region→language→final locale fallback (e.g. nl\_BE → nl → en)
* [x] Provide standalone (createStandAlone) and PSR-11 (\_\_invoke) translation factories
* [x] Include global helper functions (t(), t2(), tc()) for fast, in-code translations with placeholder and context support
* [x] Offer a centralized TranslatorRegistry with a sensible default key for global access
* [x] Load translations via configurable translation\_file\_patterns — PHP-array files or Gettext .mo files
* [x] Leverage PHP 8.1 modern features: constructor property promotion, readonly properties, strict types, and return declarations
* [x] Extensible architecture: add custom TranslatorInterface implementations or tweak fallback logic via decorators

## License

Apache-2.0 — see [LICENSE](./LICENSE)

## About SEworqs

SEworqs builds clean, reusable modules for PHP and Mendix developers.
Learn more at [github.com/seworqs](https://github.com/seworqs)

## Badges

[![Latest Version](https://img.shields.io/packagist/v/seworqs/commons-i18n.svg?style=flat-square)](https://packagist.org/packages/seworqs/commons-i18n)
[![Total Downloads](https://img.shields.io/packagist/dt/seworqs/commons-i18n.svg?style=flat-square)](https://packagist.org/packages/seworqs/commons-i18n)
[![License](https://img.shields.io/packagist/l/seworqs/commons-i18n?style=flat-square)](https://packagist.org/packages/seworqs/commons-i18n)
[![PHP Version](https://img.shields.io/packagist/php-v/seworqs/commons-i18n.svg?style=flat-square)](https://packagist.org/packages/seworqs/commons-i18n)
[![Made by SEworqs](https://img.shields.io/badge/made%20by-SEworqs-002d74?style=flat-square)](https://github.com/seworqs)
