<?php

namespace AnimalInstinct\LaravelBackpackEditorJs\app\Models\Traits;

use EditorJS\EditorJS;
use Str;
use View;

trait HasEditorJsFields
{
    public function __get($key)
    {
        if (config('laravel-backpack-editorjs.context') == 'default' && in_array($key, $this->editorJsFields)) {
            $value = $this->attributes[$key] ?? null;

            if ($this->isValidJson($value)) {
                $decodedValue = json_decode($value, true);
                $languageKey = app()->getLocale() ?? 'en';
                $translation = $decodedValue[$languageKey] ?? null;

                if (isset($translation) && $this->isValidJson($translation) && $this->hasBlocksKey($translation)) {
                    return $this->render($translation);
                }
            }
        }

        return parent::__get($key);
    }


    public function render(string $data): string
    {
        // try {
        $configJson = json_encode(config('laravel-backpack-editorjs.config') ?: []);

        // dd($data);
        // dd(json_decode($data));


        $editor = new EditorJS($data, $configJson);

        $renderedBlocks = [];

        foreach ($editor->getBlocks() as $block) {

            $viewName = "laravel-backpack-editorjs::blocks." . Str::snake($block['type'], '-');

            if (!View::exists($viewName)) {
                $viewName = 'laravel-backpack-editorjs::blocks.not-found';
            }

            $renderedBlocks[] = View::make($viewName, ['data' => $block['data']])->render();
        }

        return implode($renderedBlocks);
        // } catch (\Exception $e) {
        //     throw new \Exception(json_encode('Zaloopa'));
        // }
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
