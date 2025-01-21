<?php

namespace AnimalInstinct\LaravelBackpackEditorJs\app\Http\Controllers;

use AnimalInstinct\LaravelBackpackEditorJs\app\Http\Requests\FileUploadRequest;
use AnimalInstinct\LaravelBackpackEditorJs\app\Services\EditorJsImageUploadService as ImageUploadService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class EditorJSImageUploadController extends Controller
{
    public function uploadFile(FileUploadRequest $request)
    {
        try {
            $file = $request->file('image');

            $url = ImageUploadService::upload($file);

            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => url($url),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error in uploadFile: ' . $e->getMessage());
            return response()->json(['success' => 0, 'message' => 'File upload failed.']);
        }
    }
}
