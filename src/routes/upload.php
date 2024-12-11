<?php

use AnimalInstinct\LaravelBackpackEditorJs\app\Http\Controllers\EditorJSImageUploadController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => 'editorjs',
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
], function () {
    Route::post('/uploadFile', [EditorJSImageUploadController::class, 'uploadFile']);
    Route::post('/uploadUrl', [EditorJSImageUploadController::class, 'uploadUrl']);
});
