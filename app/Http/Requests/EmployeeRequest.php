<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
        // Atur aturan validasi berbeda untuk metode POST dan PUT
        if ($this->method() == 'PUT')
        {
            $email_rules = "required|email|unique:employees,email,{$this->employee->id}";
            $phone_rules = "required|unique:employees,phone,{$this->employee->id}";
            $nik_rules = "required|unique:employees,nik,{$this->employee->id}";
        }
        else
        {
            $email_rules = "required|email|unique:employees";
            $phone_rules = "required|unique:employees";
            $nik_rules = "required|unique:employees";
        }

        return [
            'nik' => $nik_rules,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'tgl_lahir' => 'required|date',
            'tmp_lahir' => 'required|string|max:255',
            'agama' => 'required|string|max:50',
            'gol_darah' => 'nullable|string|in:A,B,AB,O',
            'status_nikah' => 'required|string|in:single,married',
            'phone' => $phone_rules,
            'email' => $email_rules,
            'address' => 'required|string|max:500',
            'position_id' => 'required|exists:positions,id',
            'schedule_id' => 'required|exists:schedules,id',
            'rate_per_hour' => 'nullable|numeric|min:0',
            'salary' => 'required|numeric|min:0',
            'tunjangan_id' => 'nullable|exists:tunjangans,tunjangan_id',
            'pajak_id' => 'nullable|exists:pajaks,pajak_id',
            'is_active' => 'required|boolean',
        ];
    }

    /**
     * Get the custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nik.required' => 'NIK wajib diisi.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.unique' => 'Nomor telepon sudah digunakan.',
            'tgl_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tmp_lahir.required' => 'Tempat lahir wajib diisi.',
            'position_id.required' => 'Jabatan wajib dipilih.',
            'position_id.exists' => 'Jabatan yang dipilih tidak valid.',
            'schedule_id.required' => 'Jadwal kerja wajib dipilih.',
            'schedule_id.exists' => 'Jadwal kerja yang dipilih tidak valid.',
            'salary.required' => 'Gaji wajib diisi.',
            'salary.numeric' => 'Gaji harus berupa angka.',
        ];
    }
}
