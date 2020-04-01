<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
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
            "title"  => "required|unique:books",
            "cover" => "image",
            "description" => "required|min:20|max:100",
            "categories" => "required",
            "stock" => "required|numeric|min:0",
            "author" => "required",
            "publisher" => "required",
            "price" => "required|numeric|min:0"
        ];
    }

    public function messages()
    {
        return [
            "title.required" => "judul tidak boleh kosong",
            "title.unique" => "judul sudah ada",
            "cover.image" => "cover harus berupa gambar",
            "description.required" => "deskripsi tidak boleh kosong",
            "description.min" => "deskripsi minimal 20 karakter",
            "description.max" => "deskripsi maksimal 100 karakter",
            "categories.required" => "kategori tidak boleh kosong",
            "stock.required" => "stok tidak boleh kosong",
            "stock.numeric" => "stok harus angka",
            "stock.min" => "stok minimal 0",
            "author" => "author tidak boleh kosong",
            "publisher" => "publisher tidak boleh kosong",
            "price.required" => "harga tidak boleh kosong",
            "price.numeric" => "harga harus angka",
            "price.min" => "harga minimal 0" 
        ];
    }
}
