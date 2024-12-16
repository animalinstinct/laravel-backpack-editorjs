<?php

namespace AnimalInstinct\LaravelBackpackEditorJs\app\Models\Traits;

use AlAminFirdows\LaravelEditorJs\Facades\LaravelEditorJs;
use Illuminate\Support\Facades\Log;

trait HasEditorJsFields
{
    public function __get($key)
    {
        if (config('laravel-backpack-editorjs.context') == 'default' && in_array($key, $this->editorJsFields)) {
            $value = $this->attributes[$key] ?? null;

            if ($this->isValidJson($value)) {
                $decodedValue = json_decode($value, true);
                $languageKey = app()->getLocale() ?? 'en';

                if (isset($decodedValue[$languageKey]) && $this->isValidJson($decodedValue[$languageKey]) && $this->hasBlocksKey($decodedValue[$languageKey])) {
                    return LaravelEditorJs::render($decodedValue[$languageKey]);
                }
            }
        }

        return parent::__get($key);
    }

    private function isValidJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    private function hasBlocksKey($json)
    {
        $data = json_decode($json, true);
        return isset($data['blocks']);
    }
}
