<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            "name" => "required|min:5|max:100",
            "roles" => "required",
            "address" => "required|min:20|max:100",
            "phone" => "required|numeric|digits_between:10,14",
            "avatar" =>"mimes:jpg,png|max:4096"
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "nama tidak boleh kosong",
            "name.min" => "nama tidak boleh kurang dari 5 karakter",
            "name.max" => "nama paling panjang 100 karakter",
            "roles.required" => "roles tidak boleh kosong",
            "address.required" => "alamat tidak boleh kosong",
            "address.min" => "alamat tidak boleh kurang dari 20 karakter",
            "address.max" => "alamat paling panjang 100 karakter",
            "phone.required" => "nomor HP tidak boleh kosong",
            "phone.numeric" => "nomor HP harus angka",
            "phone.digits_between" => "nomor HP minimal 10 dan maksimal 14 angka",
            "avatar.mimes" => "format file yang diijinkan adalah JPG/PNG",
            "avatar.max" => "maximum size file sebesar 4 MB"
        ];
    }
}
