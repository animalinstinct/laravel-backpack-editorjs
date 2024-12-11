<?php

namespace AnimalInstinct\LaravelBackpackEditorJs\App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class Install extends Command
{

    protected $signature = 'backpack-editorjs:install';

    protected $description = 'Install the Laravel Backpack EditorJS package';

    protected $progressBar;

    protected $options = [
        'debug' => false,
    ];

    public function handle()
    {
        Artisan::call('vendor:publish', [
            '--provider' => 'AnimalInstinct\LaravelBackpackEditorJs\LaravelBackpackEditorJsServiceProvider',
            '--tag' => 'js',
            '--force' => true,
        ]);

        Artisan::call('vendor:publish', [
            '--provider' => 'AnimalInstinct\LaravelBackpackEditorJs\LaravelBackpackEditorJsServiceProvider',
            '--tag' => 'views',
            '--force' => true,
        ]);

        $this->info('Backpack EditorJS installed successfully!');
    }
}
