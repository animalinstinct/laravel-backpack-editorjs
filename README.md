# Laravel Backpack EditorJs field

Package adds new editorjs field to the Laravel Backpack admin panel.

https://github.com/animalinstinct/laravel-backpack-editorjs

## Requirements

- Laravel-Editor.js git@github.com:alaminfirdows/laravel-editorjs.git

Laravel-Editor.js uses to render editor's output.

## Installation

Install and configure parser first, More information [https://github.com/alaminfirdows/laravel-editorjs](on the package page)

```bash
composer require alaminfirdows/laravel-editorjs
php artisan vendor:publish --tag="laravel_editorjs-config"
```
Install this package

```bash
composer require animalinstinct/laravel-backpack-editorjs
```

### For laravel 9,10

Add the LaravelBackpackEditorJsServiceProvider to the service providers list.

```php
'providers' => [
    // ...
    AnimalInstinct\LaravelBackpackEditorJs\LaravelBackpackEditorJsServiceProvider::class,
    // ...
]
```

Run the install script

```bash
php artisan backpack-editorjs:install
```

## Usage

In the Backpack controllers, use 'editorjs' as a field type

```php
//YourAnyCrudController.php

$this->crud->addField([
    'name' => 'description',
    'label' => 'Description',
    'type' => 'editorjs',
]);
```
In the model import the trait, use it, and declare the fields would be used as editorjs fields for the parser could do it's job.

```php
//YourAnyModel.php

// Import the trait
use AnimalInstinct\LaravelBackpackEditorJs\app\Models\Traits\HasEditorJsFields;

// Use it in the model
use HasEditorJsFields;

// Declare the fields
protected $editorJsFields = ['description','anyfield'];
```
