<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'company_name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:10,15',
            'email' => 'required|email|unique:companys,email,' . $this->id,
            'address' => 'required|string|max:500',
            'id_rekening' => 'nullable|exists:rekenings,id_rekening',
        ];
    }

    public function messages()
    {
        return [
            'company_name.required' => 'Nama perusahaan wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
        ];
    }
}
