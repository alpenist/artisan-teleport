<?php

namespace Ait\ArtisanTeleport\Console\Commands;

use Ait\ArtisanTeleport\Console\BaseGeneratorCommand;

class SeederCreateCommand extends BaseGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new seeder class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Seeder';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        parent::handle();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->getStubFolder() . '/seeder.stub';
    }


    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        if (is_dir($this->databasePath() . '/seeds')) {
            return $this->databasePath() . '/seeds/' . $name . '.php';
        } else {
            return $this->databasePath() . '/seeders/' . $name . '.php';
        }
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param string $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        return $name;
    }
}
