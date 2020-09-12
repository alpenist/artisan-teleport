<?php

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
        'assets' => '../../../alpenist/cloudbooks',
        'base' => '../../../alpenist/cloudbooks/src',
        'namespace' => 'Ait',
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
            'namespace' => 'Ait',
        ],
        'app' => [
            'base_path' => '../../../alpenist/cloudbooks/src/App',
            'path' => '',
            'namespace' => 'App',
        ],
    ],
];
