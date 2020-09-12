# Artisan Teleport

![GitHub All Releases](https://img.shields.io/github/downloads/alpenist/artisan-teleport/total)

Provides laravel artisan support for changing the default generator folder

## Installation

Install the package via composer:

```bash
composer require alpenist/artisan-teleport
```


Publish the config file with:
```bash
php artisan vendor:publish --provider="Ait\ArtisanTeleport\ArtisanTeleportServiceProvider" --tag="config"
```

Change the namespace of your package root in the published config file, also change the root path relative to base_path() if you need to:

```php
return [
    // artisan command namespace
    'signature_prefix' => 'create',

    'defaults' => [
        'assets' => '../../../folder/subfolder',
        'base' => '../../../folder/subfolder/src',
        'namespace' => 'Acme',
    ],

    'namespaces' => [
        'ait' => [
            'base_path' => '',
            'path' => 'Domain',
            'namespace' => 'Acme',
        ],
        'app' => [
            'base_path' => '../../../folder/subfolder/src/App',
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
