<?php

namespace AnimalInstinct\LaravelBackpackEditorJs\app\Models\Traits;

use AnimalInstinct\LaravelBackpackEditorJs\app\Services\Parser;
use EditorJS\EditorJS;

trait HasEditorJsFields
{
    /**
     * Accessor for EditorJS fields.
     *
     * If the field is an EditorJS field and the context is set to 'default',
     * this method will render the EditorJS content.
     *
     * @param string $key
     *
     * @return string|null
     */
    public function __get($key)
    {
        if (config('laravel-backpack-editorjs.context') == 'default' && in_array($key, $this->editorJsFields)) {
            $value = $this->attributes[$key] ?? null;

            return Parser::render($value);
        }

        return parent::__get($key);
    }
}
