# Laravel Backpack EditorJs field

Package adds new editorjs field to the Laravel Backpack admin panel.

https://github.com/animalinstinct/laravel-backpack-editorjs

## Installation

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

Run the install

```bash
php artisan backpack-editorjs:install
```

## Using

