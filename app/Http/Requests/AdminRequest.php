<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|max:255|unique:admins,email,' . $this->id,
            'username' => 'required|string|max:50|unique:admins,username,' . $this->id,
            'role' => 'required|string|max:20',
            'image' => 'nullable|string|max:255',
            // 'password' => 'nullable|string|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'role.required' => 'Role wajib diisi.',
            // 'password.min' => 'Password harus minimal 8 karakter.',
            // 'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ];
    }
}
