<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
                'max:1000',
            ],
            'image' => [
                'required',
                'mimetypes:image/jpeg,image/png,image/jpg',
            ]
        ];
    }

    public function messages()
    {
        return [
            'title.string' => 'El título debe ser de tipo texto.',
            'title.required' => 'El título es requerido.',
            'title.max' => 'El título excede el límite permitido de carácteres.',
            'description.string' => 'La descripción debe ser de tipo texto.',
            'description.required' => 'La descripción es requerida.',
            'description.max' => 'La descrición excede el límite permitido de carácteres.',
            'image.required' => 'La imágen es requerida.',
            'image.mimetypes' => 'El archivo debe de ser de formato imágen (jpeg, png o jpg)'
        ];
    }
}
