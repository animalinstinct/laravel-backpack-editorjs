<?php

namespace AnimalInstinct\LaravelBackpackEditorJs\app\Services;

use AnimalInstinct\LaravelBackpackEditorJs\app\Services\Contracts\EditorJsImageUploadServiceContract;
use Illuminate\Http\UploadedFile;
use Storage;

class EditorJsImageUploadService implements EditorJsImageUploadServiceContract
{
    /**
     * Upload the given file to the uploads disk and return the URL.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string
     */
    public static function upload(UploadedFile $file): string
    {

        $path = $file->store('uploads', 'public');
        $url = Storage::url($path);

        return url($url);
    }
}
