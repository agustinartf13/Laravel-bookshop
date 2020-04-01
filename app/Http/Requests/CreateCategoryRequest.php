<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            "name" => "required|unique:categories",
            "image" => "mimes:jpg,png|max:4096"
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "nama kategori tidak boleh kosong",
            "name.unique" => "nama kategori sudah ada",
            "image.mimes" => "format file yang diijinkan adalah JPG/PNG",
            "image.max" => "maximum size file sebesar 4 MB"
        ];
    }
}
