# Data sanitizer to auto-cast entries, convert empty strings to null, etc.

[![Source Code](https://img.shields.io/badge/source-okipa/php--data--sanitizer-blue.svg)](https://github.com/Okipa/php-data-sanitizer)
[![Latest Version](https://img.shields.io/github/release/okipa/php-data-sanitizer.svg?style=flat-square)](https://github.com/Okipa/php-data-sanitizer/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/okipa/php-data-sanitizer.svg?style=flat-square)](https://packagist.org/packages/okipa/php-data-sanitizer)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![Build Status](https://scrutinizer-ci.com/g/Okipa/php-data-sanitizer/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Okipa/php-data-sanitizer/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/Okipa/php-data-sanitizer/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Okipa/php-data-sanitizer/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Okipa/php-data-sanitizer/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Okipa/php-data-sanitizer/?branch=master)

Often when receiving data from a client in an API or from a form request, you'll find yourself running the same data cleaning operations such as transforming `'false'` to the boolean `false`, converting `''` to `null` etc. This can be a pain.
This package simplifies the process drastically.

## Compatibility

| Laravel version | PHP version | Package version |
|---|---|---|
| ^5.5 | ^7.2 | ^1.1 |
| ^5.0 | ^5.6 | ^1.0 |

## Table of Contents
- [Installation](#installation)
  - [Laravel users](#laravel-users)
  - [Without Laravel](#without-laravel)
- [Usage](#usage)
- [Testing](#testing)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Credits](#credits)
- [Licence](#license)

## Installation

- Install the package with composer :

```bash
composer require okipa/php-data-sanitizer
```

### Laravel users

- Laravel 5.5+ uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider and the Facade alias.
If you don't use auto-discovery or if you use a Laravel 5.4- version, add the package service provider in the `register()` method from your `app/Providers/AppServiceProvider.php` :

```php
// php data sanitizer
// https://github.com/Okipa/php-data-sanitizer
$this->app->register(Okipa\DataSanitizer\Laravel\DataSanitizerServiceProvider::class);
```

- Then, add the package facade alias in the `$aliases` array from the `config/app.php`config file.

```php
'aliases' => [
    '...',
    'DataSanitizer' => Okipa\DataSanitizer\Laravel\Facades\DataSanitizer::class
]
```

When this provider is booted, you'll gain access to a `DataSanitizer` facade, which you may use in your controllers.

```php
public function index()
{
    $data = [
        // data to sanitize
    ];
    $sanitizedData = \DataSanitizer::sanitize($data);
}
```

### Without Laravel

DataSanitizer ships with native implementations of the bootloader and facade. In order to use it import class.

```php
// import the package facade
use Acid\DataSanitizer\Native\Facades\DataSanitizer;

// sanitize your data
$data = ['false', '3', ''];
$sanitizedData = DataSanitizer::sanitize($data);

// produces [false, 3, null]
```

## Usage

The only public method in the package is `sanitize($data, $default = null, $jsonDecodeAssoc = false)`.
Call the sanitizer as following :

```php
$data = ['null', 'true'];
$sanitizedData = DataSanitizer::sanitize($data);
```

`$data` can be a string, boolean, number, array, object or JSON string.
Examples of the cleaned data :

```php
''                  => null
' string trim '     => 'string trim'
'null'              => null
'false'             => false
'true'              => true
'on'                => true
'3'                 => 3
'5.07'              => 5.07
```

When using arrays and objects, the method will sanitize each element in the given data and return an array (or object) with the cleaned values.
`$default` can be used to return a default value if the resulting cleaned data is `null` or `false`.

Example:

```php
DataSanitizer::sanitize('', 'hello');
// will return 'hello'
```

`$jsonDecodeAssoc` is used for decoding JSON.
See php [json_decode documentation](http://php.net/manual/en/function.json-decode.php)

```
$jsonDecodeAssoc = true // default is false
$data = json_decode($data, null, $jsonDecodeAssoc);
// will decode your json as associative array (and as object if false)
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Arthur LORENT](https://github.com/okipa)
- [Daniel Lucas](https://github.com/daniel-chris-lucas)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

