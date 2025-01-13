<?php

namespace AnimalInstinct\LaravelBackpackEditorJs\app\Services;

use EditorJS\EditorJS;

class Parser
{
    /**
     * Render the given editorjs data.
     *
     * @param  string  $data
     * @return string
     */
    public static function render(string $value)
    {
        if (self::isValidJson($value)) {
            $decodedValue = json_decode($value, true);
            if (is_array($decodedValue)) {
                $languageKey = app()->getLocale() ?? 'en';
                $translation = $decodedValue[$languageKey] ?? null;
                if ($translation) {
                    $data = $translation;
                } else {
                    $data = $decodedValue;
                }
            }

            if (isset($data) && self::hasBlocksKey($data)) {
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

            return $data;
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
