<?php

namespace Ait\ArtisanTeleport\Console\Commands;

use Ait\ArtisanTeleport\Console\BaseGeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class NotificationCreateCommand extends BaseGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new notification class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Notification';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return;
        }

        if ($this->option('markdown')) {
            $this->writeMarkdownTemplate();
        }
    }

    /**
     * Write the Markdown template for the mailable.
     *
     * @return void
     */
    protected function writeMarkdownTemplate()
    {

        $path = $this->viewPath(
            str_replace('.', '/', $this->option('markdown')) . '.blade.php'
        );

        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }

        $this->files->put($path, file_get_contents($this->getStubFolder() . '/markdown.stub'));
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     */
    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        if ($this->option('markdown')) {
            $class = str_replace('DummyView', $this->option('markdown'), $class);
        }

        return $class;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $path = $this->getStubFolder();

        return $this->option('markdown')
            ? $path . '/markdown-notification.stub'
            : $path . '/notification.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Notifications';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the notification already exists'],

            ['markdown', 'm', InputOption::VALUE_OPTIONAL, 'Create a new Markdown template for the notification'],
        ];
    }
}
