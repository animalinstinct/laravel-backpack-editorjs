<?php

namespace AnimalInstinct\LaravelBackpackEditorJs\app\Services;

use Exception;
use Image;
use Storage;

class EditorJsImageUploadService
{
    public static function loadAndReturnPath($value, ?string $old, $sizeWidth = null, $sizeHeight = null)
    {
        $disk = config('backpack.base.root_disk_name');
        $destination_path = "/public/storage/images";

        // If the image was erased
        if ($value == null && !is_null($old)) {
            Storage::disk($disk)->delete('/public/' . $old);
            return null;
        }

        if ($value != null) {
            // Check if value is a URL or base64
            if (filter_var($value, FILTER_VALIDATE_URL)) {
                \Log::info('Value is a URL');

                // Convert URL to local file path
                $local_path = str_replace(url('/'), public_path(), $value);
                if (!file_exists($local_path)) {
                    \Log::error('Local file path does not exist: ' . $local_path);
                    throw new Exception('Local file path does not exist: ' . $local_path);
                }
                $image = Image::make($local_path);
            } elseif (starts_with($value, 'data:image')) {
                \Log::info('Value is base64 encoded');
                $image = Image::make($value);
            } else {
                // Assuming value is a file path
                \Log::info('Value is a file path');
                $image = Image::make($value);
            }

            // Debugging image instance
            if (!$image) {
                \Log::error('Failed to create image instance');
                throw new Exception('Failed to create image instance');
            }

            if ($sizeWidth || $sizeHeight) {
                $image->resize($sizeWidth, $sizeHeight, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $filename = md5($value . time()) . '.jpg';
            if (!is_null($old)) {
                Storage::disk($disk)->delete('/public/' . $old);
            }
            Storage::disk($disk)->put($destination_path . '/' . $filename, $image->stream());
            \Log::info('Image saved with filename: ' . $filename);

            return str_replace('/public', '', $destination_path) . '/' . $filename;
        } else {
            return null;
        }
    }
}
