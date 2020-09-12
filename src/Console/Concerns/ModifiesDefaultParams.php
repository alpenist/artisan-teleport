<?php


namespace Ait\ArtisanTeleport\Console\Concerns;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

trait ModifiesDefaultParams
{
    protected function normalizeSignature()
    {
        $prefix = $this->configSignaturePrefix();

        if ($prefix) {
            if (isset($this->signature)) {
                $this->signature = $prefix . ':' . $this->signature;
            } else {
                $this->name = $prefix . ':' . $this->name;
            }
        }
    }

    protected function configRootNamespace()
    {
        return $this->hasValidNamespace() ?? $this->defaultNamespace();
    }

    protected function configAssetsPath()
    {
        $path = config('artisan-teleport.defaults.assets');

        if ($path && Str::endsWith('/', $path)) {
            $path = Str::replaceLast('/', '', $path);
        }

        return $path;
    }

    protected function configRootPath()
    {
        $path = $this->getDefaultRootPath();

        if ($path && Str::endsWith('/', $path)) {
            $path = Str::replaceLast('/', '', $path);
        }

        return $path;
    }

    protected function defaultNamespace()
    {
        $default = config('artisan-teleport.defaults.namespace');

        $namespaces = $this->keysToCase('strtolower', config('artisan-teleport.namespaces'));

        $namespace = $namespaces[strtolower($default)] ?? null;

        if (! $namespaces || ! $namespace) {
            return $default;
        }

        return $namespaces[strtolower($default)]['namespace'] ?? $default;
    }

    protected function getDefaultRootPath()
    {
        $default = config('artisan-teleport.defaults.base');

        $namespaces = $this->keysToCase('strtolower', config('artisan-teleport.namespaces'));

        if (! $namespaces || ! $namespaces[strtolower($this->configRootNamespace())]) {
            return $default;
        }

        return $namespaces[strtolower($default)]['base_path'] ?? $default;
    }

    protected function configSignaturePrefix()
    {
        $prefix = config('artisan-teleport.signature_prefix');

        if ($prefix && Str::endsWith(':', $prefix)) {
            $prefix = Str::replaceLast(':', '', $prefix);
        }

        return $prefix;
    }

    protected function addNamespaceArgument(): void
    {
        $this->getDefinition()->addArguments([
            new InputArgument(
                "namespace",
                InputArgument::OPTIONAL,
                "The namespace of the class"
            ),
        ]);
    }

    /**
     * Get the desired class namespace from the input.
     *
     * @return string
     */
    protected function getNameSpaceInput()
    {
        return trim($this->argument('namespace'));
    }

    /**
     * @return string|null
     */
    protected function hasValidNamespace()
    {
        $key = strtolower($this->getNameSpaceInput());

        $namespaces = $this->keysToCase('strtolower', config('artisan-teleport.namespaces'));

        if (
            ! $key ||
            ! is_array($namespaces) ||
            empty($namespaces) ||
            ! key_exists($key, $namespaces)
        ) {
            return null;
        }

        return $namespaces[$key]['namespace'] ?? null;
    }

    /**
     * @return string|null
     */
    protected function hasValidRootPath()
    {
        $key = strtolower($this->getNameSpaceInput());

        if (! $key) {
            return $this->configRootPath();
        }

        $namespaces = $this->keysToCase('strtolower', config('artisan-teleport.namespaces'));

        if (
            ! $key ||
            ! is_array($namespaces) ||
            empty($namespaces) ||
            ! key_exists($key, $namespaces)

        ) {
            return $this->configRootPath();
        }

        if (! $this->hasValidNamespace()) {
            return $this->configRootPath();
        }

        $path = $namespaces[$key]['base_path'] ?? null;

        if ($path) {
            return $path;
        }

        $defaultRoot = $this->configRootPath();

        $path = $namespaces[$key]['path'] ?? null;
        if ($path) {
            return $defaultRoot . '/' . trim($path, '/');
        }

        return $defaultRoot;
    }

    protected function keysToCase(callable $callback, $array)
    {
        if (! $array || empty($array)) {
            return null;
        }

        return array_combine(
            array_map($callback, array_keys($array)),
            array_values($array)
        );
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStubFolder()
    {
        return __DIR__ . '/../stubs';
    }

    protected function resourcePath($path = '')
    {
        return $this->rootBasePath('resources') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    protected function configPath($path = '')
    {
        return $this->rootBasePath('config') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    protected function databasePath($path = '')
    {
        return $this->rootBasePath('database') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function langPath()
    {
        return $this->resourcePath() . DIRECTORY_SEPARATOR . 'lang';
    }

    protected function rootBasePath($path = '')
    {
        return $this->configAssetsPath() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
