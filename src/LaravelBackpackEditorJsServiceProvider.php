<?php

namespace AnimalInstinct\LaravelBackpackEditorJs;

use Illuminate\Support\ServiceProvider;

class LaravelBackpackEditorJsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutes();
        $this->publishFiles();
    }

    public function register()
    {
        $this->commands($this->commands);
    }

    protected $commands = [
        \AnimalInstinct\LaravelBackpackEditorJs\app\Console\Commands\Install::class
    ];

    public function publishFiles()
    {
        $views = [__DIR__ . '/resources/views' => resource_path('views/vendor/backpack')];
        $js = [__DIR__ . '/resources/assets/js' => public_path('packages/editorjs')];

        $this->publishes($views, 'views');
        $this->publishes($js, 'js');
    }

    public function loadRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/upload.php');
    }
}
