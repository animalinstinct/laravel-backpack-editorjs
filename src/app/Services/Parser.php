<?php

namespace AnimalInstinct\LaravelBackpackEditorJs\app\Services;

use EditorJS\EditorJS;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class Parser
{
    /**
     * Render the given editorjs data.
     *
     * @param  string  $value JSON string from EditorJS
     * @return string|null HTML output or null for invalid input
     */
    public static function render(string $value)
    {
        if (!self::isValidJson($value)) {
            return $value;
        }

        $decodedValue = json_decode($value, true);
        $data = self::extractTranslatedData($decodedValue);

        if (self::hasBlocks($data)) {
            return self::renderBlocks($data);
        }

        return $data;
    }

    /**
     * Extract translated content based on current locale.
     *
     * @param  array  $decodedValue
     * @return array|mixed
     */
    private static function extractTranslatedData($decodedValue)
    {

        if (!is_array($decodedValue)) {
            return $decodedValue;
        }

        $languageKey = app()->getLocale() ?? 'en';
        $translation = $decodedValue[$languageKey] ?? null;

        if (!isset($translation)) {
            $data = json_encode($decodedValue);
            if ($data === false) {
                throw new \Exception('JSON encoding error: ' . json_last_error_msg());
            }
        } else {
            $data = $translation;
        }

        return $data;
    }

    /**
     * Render blocks from EditorJS data.
     *
     * @param  array  $data
     * @return string
     */
    private static function renderBlocks($data)
    {
        $configJson = json_encode(config('laravel-backpack-editorjs.config') ?: []);
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
    }

    /**
     * Check if given string is valid JSON.
     *
     * @param string $string
     * @return bool
     */
    private static function isValidJson(string $string): bool
    {
        if (empty($string)) {
            return false;
        }

        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Check if the given data has 'blocks' key.
     *
     * @param mixed $data
     * @return bool
     */
    private static function hasBlocks($data): bool
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        return is_array($data) && isset($data['blocks']);
    }
}
