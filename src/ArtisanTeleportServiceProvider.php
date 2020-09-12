<?php

namespace Ait\ArtisanTeleport;

use Illuminate\Support\ServiceProvider;

class ArtisanTeleportServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/artisan-teleport.php' => config_path('artisan-teleport.php'),
            ], 'config');


            $this->registerArtisanCommands();
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/artisan-teleport.php', 'artisan-teleport');
    }

    /**
     * @param string $namespace
     */
    private function registerArtisanCommands($namespace = 'Ait\\ArtisanTeleport\\Console\\Commands\\'): void
    {
        $finder = new \Symfony\Component\Finder\Finder();
        $finder->files()->in(__DIR__ . '/Console/Commands');

        $classes = [];

        foreach ($finder as $file) {
            $classes[] = $namespace . $file->getBasename('.php');
        }

        if (count($classes)) {
            $this->commands($classes);
        }
    }
}
