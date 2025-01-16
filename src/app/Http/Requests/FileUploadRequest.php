<?php

namespace AnimalInstinct\LaravelBackpackEditorJs\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }
    public function rules()
    {
        return [
            'image' => 'required|mimes:jpg,png,jpeg,gif,svg,webp',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'image.required' => 'The image field is required.',
            'image.mimes' => 'The image must be a file of type: jpg, png, jpeg, gif, svg, webp.',
        ];
    }
}
