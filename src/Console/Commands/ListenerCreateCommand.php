<?php

namespace Ait\ArtisanTeleport\Console\Commands;

use Ait\ArtisanTeleport\Console\BaseGeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ListenerCreateCommand extends BaseGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'listener';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new event listener class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Listener';

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $event = $this->option('event');

        $namespace = trim($this->rootNamespace(), '\\') . '\\'; //$this->laravel->getNamespace()

        if (! Str::startsWith($event, [
            $namespace,
            'Illuminate',
            '\\',
        ])) {
            $event = $namespace . 'Events\\' . $event;
        }

        $stub = str_replace(
            'DummyEvent',
            class_basename($event),
            parent::buildClass($name)
        );

        return str_replace(
            'DummyFullEvent',
            trim($event, '\\'),
            $stub
        );
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $path = $this->getStubFolder();

        if ($this->option('queued')) {
            return $this->option('event')
                ? $path . '/listener-queued.stub'
                : $path . '/listener-queued-duck.stub';
        }

        return $this->option('event')
            ? $path . '/listener.stub'
            : $path . '/listener-duck.stub';
    }

    /**
     * Determine if the class already exists.
     *
     * @param string $rawName
     * @return bool
     */
    protected function alreadyExists($rawName)
    {
        return class_exists($rawName);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Listeners';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['event', 'e', InputOption::VALUE_OPTIONAL, 'The event class being listened for'],

            ['queued', null, InputOption::VALUE_NONE, 'Indicates the event listener should be queued'],
        ];
    }
}
