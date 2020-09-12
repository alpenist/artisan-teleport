# Artisan Teleport

![Packagist Downloads](https://img.shields.io/packagist/dt/alpenist/artisan-teleport?color=green&label=Downloads&logo=Github&style=for-the-badge)

Provides laravel artisan support for more controll on changing the default generated destination folder

## Who is it for
The default laravel folder structure works perfectly fine for most cases but if you decided to take a different approach organizing your folder structure especially for larger than usual projects (**Hexagonal Architecture**) then this package is useful for you if you still want to use the artisan **`make`** command to generate your stubs.

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

    /*
    |--------------------------------------------------------------------------
    | Artisan Teleport Signature
    |--------------------------------------------------------------------------
    |
    | This option controls the default artisan teleport "command" signature,
    | name. If no value is provided artisan teleport will simply not load.
    |
    */

    'signature_prefix' => 'create',

    /*
    |--------------------------------------------------------------------------
    | Artisan Teleport Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default base path and namespace that will
    | be used to generate stubs in the location specified. If left empty
    | it will default to the "base_path()" and laravel Application
    | default namespace.
    |
    | Default namespace will be overridden if a key with the same name is found
    | in the namespaces array below
    |
    */

    'defaults' => [
        'assets' => '../../../folder/subfolder',
        'base' => '../../../folder/subfolder/src',
        'namespace' => 'Acme',
    ],

    /*
    |--------------------------------------------------------------------------
    | Artisan Teleport Namespaces
    |--------------------------------------------------------------------------
    |
    | You may specify multiple namespaces which allows you to generate
    | any stubs within the specified namespace and will also set the root
    | location of the generator at run time.
    |
    | Lets say you set the default namespace to "Acme" and the base folder
    | to "Company" now when you generate a model it will have
    | namespace Acme\Models; and the file location will be in Company/Models
    |
    | Now suppose you have a Domain folder where you want to keep school course related
    | logic, you may generate a model in the "School" namespace and place it under
    | School/Models folder on the fly by passing a second argument to the artisan command
    | like this: php artisan create:model Course School
    | (assuming your signature prefix is "create")
    |
    | Each key has a required 'namespace' key if not found the key will be discarded and will
    | revert to the default namespace settings
    |
    */

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


## Security

If you discover any security related issues, please use the issue tracker.

## Credits

- [Hiro Garabedian](https://github.com/Ait)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
