# Artisan Teleport

[![Latest Version on Packagist](https://img.shields.io/packagist/v/alpenist/artisan-teleporter.svg?style=flat-square)](https://packagist.org/packages/alpenist/artisan-teleporter)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/alpenist/artisan-teleporter/run-tests?label=tests)](https://github.com/alpenist/artisan-teleporter/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/alpenist/artisan-teleporter.svg?style=flat-square)](https://packagist.org/packages/alpenist/artisan-teleporter)


Provides laravel artisan support for changing the default generator folder

## Installation

Install the package via composer:

```bash
composer require alpenist/artisan-teleporter
```


Publish the config file with:
```bash
php artisan vendor:publish --provider="Ait\ArtisanTeleporter\ArtisanTeleporterServiceProvider" --tag="config"
```

Change the namespace of your package root in the published config file, also change the root path relative to base_path() if you need to:

```php
return [
    // artisan command namespace
    'signature_prefix' => 'create',

    'defaults' => [
        'assets' => '../../../alpenist/cloudbooks',
        'base' => '../../../alpenist/cloudbooks/src',
        'namespace' => 'Ait',
    ],

    'namespaces' => [
        'ait' => [
            'base_path' => '',
            'path' => 'Domain',
            'namespace' => 'Ait',
        ],
        'app' => [
            'base_path' => '../../../alpenist/cloudbooks/src/App',
            'path' => '',
            'namespace' => 'App',
        ],
    ],
];
```

## Usage
Assuming prefix is set to **`create`**
``` bash
php artisan create:model Client
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please use the issue tracker.

## Credits

- [Hiro Garabedian](https://github.com/Ait)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
