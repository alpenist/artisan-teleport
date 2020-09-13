# Artisan Teleport

![Packagist Downloads](https://img.shields.io/packagist/dt/alpenist/artisan-teleport?color=green&label=Downloads&logo=Github&style=for-the-badge)

Provides Laravel Artisan support for more control on changing the default generated destination folder

## Who is it for
The default laravel folder structure works perfectly fine for most cases but if you decided to take a different approach organizing your folder structure especially for larger than usual projects for example  (**Hexagonal**, **Domain Driven** Architecture, etc....) then this package is useful for you if you still want to use **`artisan`** to generate your stubs.

You can alternate with the default make command and generate stubs easily in scenarios like this
```
 |-- laravel
    |-- bootstrap
    ...   
    |-- src
       |-- App
          |-- Console
          |-- Exceptions
          |-- Providers
          ...
       |-- Acme
          |-- Clients
             |-- Models
             ...
          |-- Invoices
             |-- Models
             |-- Events
             |-- Observers
             ...
         ...   
       ...   
    ...   
    |-- vendor
    |-- .env    
    |-- server.php  
```
or even hook to the composer in laravel folder from a completely different project outside the main laravel application if you want
```
 |-- laravel              |-- Project
    |-- bootstrap            |-- config
    ...                      |-- database
    |-- vendor               |-- resources
    |-- .env                 |-- src
    |-- server.php              |-- App
                                   |-- Console
                                   |-- Exceptions
                                   |-- Providers
                                   ...
                                |-- Acme
                                   |-- Clients
                                      |-- Models
                                      ...
                                   |-- Invoices
                                      |-- Models
                                      |-- Events
                                      |-- Observers
                                      ...
                                   ...
                                ...
                             |-- tests
```

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
        'assets' => '../../../folder/sub-folder',
        'base' => '../../../folder/sub-folder/src/Acme',
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
        // The first key will override the defaults setting above
        // Now the defaults will be set to: 
        // namespace: AcmeCorp
        // base_path: ../../../folder/sub-folder/src/AcmeCorp/Domain
        'acme' => [
            'base_path' => '../../../folder/sub-folder/src/AcmeCorp',
            'path' => 'Domain',
            'namespace' => 'AcmeCorp',
        ],
        'app' => [
            'base_path' => '../../../folder/sub-folder/src/App',
            'path' => '',
            'namespace' => 'App',
        ],
    ],
];
```

## Usage
Assuming **`signature_prefix`** is set to **`create`** and the default namespace set to **`App`** and the base path is set to **`project/src/App`** the following line will create a model with the namespace **`App\Clients\Models`** in **`project/src/App/Clients/Models`** folder
``` bash
php artisan create:model Clients/Client
```
If you have defined an additional namespace **`Acme`** in the config which has base set to **`project/src/Acme`**  you may provide the namespace as a second argument and it will create a model with the namespace **`Acme\Employees\Models`** in **`project/src/Acme/Employees/Models`** folder

``` bash
php artisan create:model Employees/Employee Acme
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
