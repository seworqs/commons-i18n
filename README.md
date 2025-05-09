# Seworqs Commons i18n

A lightweight, standalone internationalization module for PHP 8.1 that integrates both PHP‑array and Gettext back‑ends with advanced locale fallback logic and PSR‑11 compatibility.

## Installation

Install via Composer:

```bash
composer require seworqs/commons-i18n
```

## Usage
```php
use Seworqs\Commons\I18n\Factory\TranslatorFactory;
use Seworqs\Commons\I18n\TranslatorRegistry;

// Create a standalone translator
$translator = TranslatorFactory::createStandAlone([
    'locale' => 'nl_BE',
    'fallbackLocale' => 'en',
    'translation_file_patterns' => [
        ['type'=>'phpArray','base_dir'=>'path/to/language','pattern'=>'%s.php'],
        ['type'=>'gettext','base_dir'=>'path/to/language','pattern'=>'%s.mo'],
    ],
]);
TranslatorRegistry::register('default', $translator);

// Use helpers
echo t('welcome.message');
echo t2('item.one','item.many',5);
echo tc('errors','not_found');
```

## Features
- [X] Combine multiple translation back-ends (PHP-array, Gettext) into a single composite translator
- [X] Implement region→language→final locale fallback (e.g. nl_BE → nl → en)
- [X] Provide standalone (createStandAlone) and PSR-11 (__invoke) translation factories
- [X] Include global helper functions (t(), t2(), tc()) for fast, in‑code translations with placeholder and context support
- [X] Offer a centralized TranslatorRegistry with a sensible default key for global access
- [X] Load translations via configurable translation_file_patterns—PHP-array files or Gettext .mo files
- [X] Leverage PHP 8.1 modern features: constructor property promotion, readonly properties, strict types, and return declarations
- [X] Extensible architecture: add custom TranslatorInterface implementations or tweak fallback logic via decorators

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

