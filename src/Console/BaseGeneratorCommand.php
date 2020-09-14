<?php


namespace Ait\ArtisanTeleport\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

abstract class BaseGeneratorCommand extends GeneratorCommand
{
    use Concerns\ModifiesDefaultParams;


    public function __construct(Filesystem $files)
    {
        // if we have a signature prefix in config then we will normalize
        // the signature or the name to reflect that prefix
        $this->normalizeSignature();

        parent::__construct($files);

        $this->addNamespaceArgument();
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        $path = $this->hasValidRootPath() ?? $this->laravel['path'];

        return $path . '/' . str_replace('\\', '/', trim($name, '\\')) . '.php';
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        $configNamespace = $this->configRootNamespace();

        if ($configNamespace) {
            $configNamespace = Str::replaceLast('\\', '', $configNamespace) . '\\';
        }

        return $configNamespace ?? $this->laravel->getNamespace();
    }

    /**
     * Get the first view directory path from the application configuration.
     *
     * @param string $path
     * @return string
     */
    protected function viewPath($path = '')
    {
        return $this->resourcePath('views') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }


    /**
     * Qualify the given model class base name.
     *
     * @param string $model
     * @return string
     */
    protected function qualifyModel(string $model)
    {
        $model = ltrim($model, '\\/');

        $model = str_replace('/', '\\', $model);

        $rootNamespace = $this->rootNamespace() . '\\';

        if (Str::startsWith($model, $rootNamespace)) {
            return $model;
        }

        return $rootNamespace . 'Models\\' . $model;

//        return is_dir(app_path('Models'))
//            ? $rootNamespace.'Models\\'.$model
//            : $rootNamespace.$model;
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param string $stub
     * @param string $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $searches = [
            ['DummyNamespace', 'DummyRootNamespace', 'NamespacedDummyUserModel'],
            ['{{ namespace }}', '{{ rootNamespace }}', '{{ namespacedUserModel }}'],
            ['{{namespace}}', '{{rootNamespace}}', '{{namespacedUserModel}}'],
        ];

        $namespace = trim($this->rootNamespace(), '\\') . "\\";

        foreach ($searches as $search) {
            $stub = str_replace(
                $search,
                [$this->getNamespace($name), $namespace, $this->userProviderModel()],
                $stub
            );
        }

        return $this;
    }
}
