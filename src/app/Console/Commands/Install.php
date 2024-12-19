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
        $steps = [
            'Publishing JS assets' => [
                '--provider' => 'AnimalInstinct\LaravelBackpackEditorJs\LaravelBackpackEditorJsServiceProvider',
                '--tag' => 'js',
                '--force' => true,
            ],
            'Publishing views' => [
                '--provider' => 'AnimalInstinct\LaravelBackpackEditorJs\LaravelBackpackEditorJsServiceProvider',
                '--tag' => 'views',
                '--force' => true,
            ],
            'Publishing config' => [
                '--provider' => 'AnimalInstinct\LaravelBackpackEditorJs\LaravelBackpackEditorJsServiceProvider',
                '--tag' => 'config',
                '--force' => true,
            ],
        ];

        $this->info('Starting the installation...');

        foreach ($steps as $message => $options) {
            $this->info($message . '...');
            Artisan::call('vendor:publish', $options);
            $this->info($message . ' completed.');
        }

        $this->info('Backpack EditorJS installed successfully!');
    }
}
