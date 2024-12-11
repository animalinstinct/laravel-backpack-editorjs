<?php

namespace AnimalInstinct\LaravelBackpackEditorJs\app\Http\Controllers;

use AnimalInstinct\LaravelBackpackEditorJs\app\Services\EditorJsImageUploadService as ImageUploadService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EditorJSImageUploadController extends Controller
{
    public function uploadFile(Request $request)
    {
        try {
            $path = ImageUploadService::loadAndReturnPath($request->file('image')->getRealPath(), null);
            Log::info('Image path returned: ' . $path);
            return response()->json(['success' => 1, 'file' => ['url' => asset($path)]]);
        } catch (\Exception $e) {
            Log::error('Error in uploadFile: ' . $e->getMessage());
            return response()->json(['success' => 0, 'message' => 'File upload failed.']);
        }
    }

    public function uploadUrl(Request $request)
    {
        try {
            $url = $request->input('url');
            $path = ImageUploadService::loadAndReturnPath($url, null);
            Log::info('Image path returned: ' . $path);
            return response()->json(['success' => 1, 'file' => ['url' => asset($path)]]);
        } catch (\Exception $e) {
            Log::error('Error in uploadUrl: ' . $e->getMessage());
            return response()->json(['success' => 0, 'message' => 'URL upload failed.']);
        }
    }
}
