<?php

namespace AnimalInstinct\LaravelBackpackEditorJs\app\Http\Controllers\Traits;

use Illuminate\Support\Facades\Log;

trait EditorJsField
{

    /**
     * Check if the given string is valid EditorJs content and return the field type.
     * If the content is not valid EditorJs, return a backup field type.
     *
     * @param  mixed  $model
     * @param  string  $fieldName
     * @param  string  $backupFieldType
     * @return string
     */
    public static function withBackup($model, string $fieldName, string $backupFieldType = 'text')
    {
        if ($model && $model->getAttribute($fieldName)) {
            if (self::isValidEditorJsContent($model->$fieldName)) {
                return 'editorjs';
            } else {
                return $backupFieldType;
            }
        } else {
            return 'editorjs';
        }
    }

    /**
     * Check if the given string is valid EditorJs content.
     * 
     * @param string|null $str
     * @return bool
     */
    protected static function isValidEditorJsContent($str)
    {
        if (empty($str)) {
            return false;
        }

        try {
            $parsed = json_decode($str, true);
            return isset($parsed['blocks']);
        } catch (\Exception $e) {
            Log::error('Invalid JSON content for EditorJs: ' . $e->getMessage());
            return false;
        }
    }
}
