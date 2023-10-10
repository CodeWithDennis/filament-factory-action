# Integrate an action into tables for data generation via Laravel factoriess

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codewithdennis/filament-factory-action.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-factory-action)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/codewithdennis/filament-factory-action/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/codewithdennis/filament-factory-action/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/codewithdennis/filament-factory-action/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/codewithdennis/filament-factory-action/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/codewithdennis/filament-factory-action.svg?style=flat-square)](https://packagist.org/packages/codewithdennis/filament-factory-action)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require codewithdennis/filament-factory-action
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-factory-action-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-factory-action-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-factory-action-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$factoryAction = new CodeWithDennis\FactoryAction();
echo $factoryAction->echoPhrase('Hello, CodeWithDennis!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [CodeWithDennis](https://github.com/CodeWithDennis)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
