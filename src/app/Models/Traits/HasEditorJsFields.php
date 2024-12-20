<?php

namespace AnimalInstinct\LaravelBackpackEditorJs\app\Models\Traits;

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

            if (self::isValidJson($value)) {
                $decodedValue = json_decode($value, true);
                $languageKey = app()->getLocale() ?? 'en';
                $translation = $decodedValue[$languageKey] ?? null;

                if (isset($translation) && self::hasBlocksKey($translation)) {
                    return $this->render($translation);
                }
            }
        }

        return parent::__get($key);
    }



    /**
     * Renders the given editorjs data.
     *
     * @param  string  $data
     * @return string
     */
    public function render(string $data): string
    {
        $configJson = json_encode(config('laravel-backpack-editorjs.config') ?: []);
        $editor = new EditorJS($data, $configJson);
        $renderedBlocks = [];

        foreach ($editor->getBlocks() as $block) {

            $viewName = "laravel-backpack-editorjs::blocks." . \Str::snake($block['type'], '-');

            if (!\View::exists($viewName)) {
                $viewName = 'laravel-backpack-editorjs::blocks.not-found';
            }

            $renderedBlocks[] = \View::make($viewName, ['data' => $block['data']])->render();
        }

        return implode($renderedBlocks);
    }

    /**
     * Check if the given string is valid EditorJs content.
     * 
     * @param string|null $str
     * @return bool
     */
    private static function isValidEditorJsContent(string $str): bool
    {
        if (empty($str)) {
            return false;
        }

        try {
            $parsed = json_decode($str, true);
            return isset($parsed['blocks']);
        } catch (\Exception $e) {
            \Log::error('Invalid JSON content for EditorJs: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if given string is valid JSON.
     *
     * @param string $string
     *
     * @return bool
     */
    private static function isValidJson(string $string): bool
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Checks if the given string is valid JSON and has 'blocks' key.
     *
     * @param string $json
     *
     * @return bool
     */
    private static function hasBlocksKey(string $json): bool
    {
        $data = json_decode($json, true);
        return isset($data['blocks']);
    }
}
