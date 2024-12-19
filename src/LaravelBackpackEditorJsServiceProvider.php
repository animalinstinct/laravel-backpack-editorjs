<?php

namespace AnimalInstinct\LaravelBackpackEditorJs;

use Illuminate\Support\ServiceProvider;

class LaravelBackpackEditorJsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        config(['laravel-backpack-editorjs.context' => 'default']);

        $this->loadRoutes();
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'laravel-backpack-editorjs');
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
        $views = [__DIR__ . '/resources/views/crud' => resource_path('views/vendor/backpack')];
        $js = [__DIR__ . '/resources/assets/js' => public_path('packages/editorjs')];
        $config = [__DIR__ . '/config/laravel-backpack-editorjs.php' => config_path('laravel-backpack-editorjs.php')];

        $this->publishes($views, 'views');
        $this->publishes($js, 'js');
        $this->publishes($config, 'config');
    }

    public function loadRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/upload.php');
    }
}
