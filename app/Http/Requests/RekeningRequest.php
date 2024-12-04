<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RekeningRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Pastikan user memiliki akses untuk membuat atau memperbarui data
    }

    public function rules()
    {
        $idRekening = $this->route('id_rekening') ?? $this->input('id_rekening');

        return [
            'no_rekening' => 'required|string|max:50|unique:rekenings,no_rekening,' . $idRekening . ',id_rekening',
            'nama_pemilik' => 'required|string|max:255',
            'rekening_name' => 'required|string|max:100',
            'type_rekening' => 'required|string|max:50',
            'saldo' => 'required|numeric|min:0',
            'bank_id' => 'required|exists:banks,bank_id', // Pastikan bank_id valid dan ada di tabel banks
        ];
    }

    public function messages()
    {
        return [
            'no_rekening.required' => 'Nomor rekening wajib diisi.',
            'no_rekening.unique' => 'Nomor rekening sudah terdaftar.',
            'nama_pemilik.required' => 'Nama pemilik wajib diisi.',
            'rekening_name.required' => 'Nama rekening wajib diisi.',
            'type_rekening.required' => 'Tipe rekening wajib diisi.',
            'saldo.required' => 'Saldo wajib diisi.',
            'saldo.numeric' => 'Saldo harus berupa angka.',
            'saldo.min' => 'Saldo tidak boleh kurang dari 0.',
            'bank_id.required' => 'ID bank wajib diisi.',
            'bank_id.exists' => 'ID bank tidak valid.',
        ];
    }
}
