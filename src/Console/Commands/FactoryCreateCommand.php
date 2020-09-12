<?php

namespace Ait\ArtisanTeleport\Console\Commands;

use Ait\ArtisanTeleport\Console\BaseGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class FactoryCreateCommand extends BaseGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'factory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model factory';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Factory';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->getStubFolder() . '/factory.stub';
    }


    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     */
    protected function buildClass($name)
    {
        $defaultNamespace = $this->rootNamespace();

        $namespaceModel = $this->option('model')
            ? $this->qualifyModel('\\'.$this->option('model'))
            : $this->qualifyModel('Model');

        $model = class_basename($namespaceModel);

        if (Str::startsWith($namespaceModel, $defaultNamespace . '\\Models')) {
            $namespace = Str::beforeLast(
                'Database\\Factories\\' . Str::after(
                    $namespaceModel,
                    $defaultNamespace . '\\Models\\'
                ),
                '\\'
            );
        } else {
            $namespace = $defaultNamespace.'\\Database\\Factories';
        }

        $replace = [
            '{{ factoryNamespace }}' => $namespace,
            'NamespacedDummyModel' => $namespaceModel,
            '{{ namespacedModel }}' => $namespaceModel,
            '{{namespacedModel}}' => $namespaceModel,
            'DummyModel' => $model,
            '{{ model }}' => $model,
            '{{model}}' => $model,
        ];

        return str_replace(
            array_keys($replace),
            array_values($replace),
            parent::buildClass($name)
        );
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        $rootNamespace = $this->rootNamespace();

        $name = Str::replaceFirst($rootNamespace.'\\', '', $name);

        $name = Str::finish($this->argument('name'), 'Factory');

        return $this->databasePath() . '/factories/' . str_replace('\\', '/', $name) . '.php';
//        return $this->laravel->databasePath() . '/factories/' . str_replace('\\', '/', $name) . '.php';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The name of the model'],
        ];
    }
}
