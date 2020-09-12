<?php

namespace Ait\ArtisanTeleport\Console\Commands;

use Ait\ArtisanTeleport\Console\BaseGeneratorCommand;
use Illuminate\Support\Str;

class TestCreateCommand extends BaseGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'test {name : The name of the class} {--unit : Create a unit test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new test class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Test';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $path = $this->getStubFolder();

        return $this->option('unit')
            ? $path . '/test.unit.stub'
            : $path . '/test.stub';
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


        return $this->rootBasePath('tests') . str_replace('\\', '/', $name) . '.php';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        if ($this->option('unit')) {
            return $rootNamespace . '\Unit';
        } else {
            return $rootNamespace . '\Feature';
        }
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->defaultNamespace().'\\Tests';
    }
}
