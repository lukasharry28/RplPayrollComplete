<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayrollScheduleRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna berhak membuat request ini.
     *
     * @return bool
     */
    public function authorize()
    {
        // Pastikan untuk memvalidasi apakah user yang sedang login memiliki izin untuk membuat data payroll schedule
        return true;
    }

    /**
     * Tentukan aturan validasi untuk request ini.
     *
     * @return array
     */
    public function rules()
    {
        // Tentukan aturan validasi untuk data payroll schedule
        return [
            'company_id' => 'required|exists:companies,company_id',  // Pastikan company_id valid dan ada di tabel companies
            'payroll_date' => 'required|date',  // Validasi agar payroll_date adalah tanggal yang sah
            'payroll_status' => 'required|string|in:pending,completed',  // Status penggajian yang valid (misalnya: pending, completed)
        ];
    }

    /**
     * Tentukan pesan kustom untuk validasi.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'company_id.required' => 'Perusahaan wajib dipilih.',
            'company_id.exists' => 'Perusahaan yang dipilih tidak valid.',
            'payroll_date.required' => 'Tanggal penggajian wajib diisi.',
            'payroll_date.date' => 'Tanggal penggajian harus dalam format tanggal yang valid.',
            'payroll_status.required' => 'Status penggajian wajib diisi.',
            'payroll_status.in' => 'Status penggajian harus salah satu dari: pending, completed.',
        ];
    }

    /**
     * Tentukan atribut yang perlu diubah nama pesan errornya.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'company_id' => 'Perusahaan',
            'payroll_date' => 'Tanggal Penggajian',
            'payroll_status' => 'Status Penggajian',
        ];
    }
}
