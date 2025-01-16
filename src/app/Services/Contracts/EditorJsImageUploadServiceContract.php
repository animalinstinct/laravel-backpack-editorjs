<?php

namespace AnimalInstinct\LaravelBackpackEditorJs\app\Services\Contracts;

use Illuminate\Http\UploadedFile;

interface EditorJsImageUploadServiceContract
{
    /**
     * Upload the given file to the uploads disk and return the URL.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string
     */
    public static function upload(UploadedFile $file): string;
}
