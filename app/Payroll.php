<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id',
        'company_id',
        'date',
        'payroll_status',
        'payschedule_id',
        'deduction',
        'pajak',
        'tunjangan',
        'total_amount',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'deduction' => 'decimal:2',
        'pajak' => 'decimal:2',
        'tunjangan' => 'decimal:2',
    ];


    // Mengambil format tanggal dalam format yang diinginkan
    public function getDateAttribute(){
        return date("M d, Y", strtotime($this->attributes['date']));
    }

    // Menyimpan tanggal dalam format Y-m-d
    public function setDateAttribute($value){
        $this->attributes['date'] = date("Y-m-d", strtotime($value));
    }

    // Relasi dengan model Employee
    // public function employee()
    // {
    //     return $this->belongsTo(Employee::class, 'employee_id', 'id');
    // }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // Relasi dengan model Company
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    // Relasi dengan PayrollSchedule
    public function payrollschedule()
    {
        return $this->belongsTo(PayrollSchedule::class, 'payschedule_id', 'payschedule_id');
    }

    // Relasi dengan model Pajak
    public function pajak()
    {
        return $this->belongsTo(Pajak::class, 'pajak_id', 'pajak_id');
    }

    // Relasi dengan model Tunjangan
    public function tunjangan()
    {
        return $this->belongsTo(Tunjangan::class, 'tunjangan_id', 'tunjangan_id');
    }

    // Relasi dengan model Deduction
    public function deduction()
    {
        return $this->belongsTo(Deduction::class, 'deduction_id', 'deduction_id');
    }

    public function getTotalAmountAttribute($value)
    {
        return number_format($value, 2); // Format the total_amount value with 2 decimal places
    }


    public function retrieveEmployeeBenefits()
    {
        $employee = $this->employee; // Ambil data employee terkait

        // Ambil data deduction melalui relasi
        $deduction = $employee->deduction;
        $this->deduction = $deduction ? $deduction->amount : 0;

        // Ambil data pajak melalui relasi
        $pajak = $employee->pajak;
        $this->pajak = $pajak ? $pajak->tax_amount : 0;

        // Ambil data tunjangan melalui relasi
        $tunjangan = $employee->tunjangan;
        $this->tunjangan = $tunjangan ? $tunjangan->rate_amount : 0;

        // Simpan nilai-nilai tersebut ke database
        $this->save();
    }


    // Fungsi untuk menghitung total gaji (total_amount)
    public function calculateTotalAmount()
    {
        $employee = $this->employee; // Ambil data employee terkait

        // Ambil data tunjangan, pajak, potongan, dan lembur
        // $overtimeAmount = $this->employee()->getGrossAmountAttribute() ?? 0; // Ambil data dari lembur
        $deductionAmount = $this->deduction ?? 0; // Ambil jumlah potongan
        $taxAmount = $this->pajak ?? 0; // Ambil jumlah pajak
        $allowanceAmount = $this->tunjangan ?? 0; // Ambil jumlah tunjangan

        // Ambil gaji pokok karyawan
        $baseSalary = $employee->salary ?? 0;

        // Perhitungan total_amount = gaji pokok + tunjangan - pajak - deduction + overtime
        $totalAmount = $baseSalary + $allowanceAmount - $taxAmount - $deductionAmount;

        return $totalAmount;
    }

    // Setter untuk menyimpan total_amount setelah dihitung
    public function setTotalAmountAttribute()
    {
        $this->retrieveEmployeeBenefits();

        $this->attributes['total_amount'] = $this->calculateTotalAmount(); // Menghitung dan menyimpan total_amount
    }

    // public function processPayrollTransaction(Payroll $payroll)
    // {
    //     $employeeBank = $payroll->employee->rekening;
    //     $companyBank = $payroll->company->rekening;

    //     if (!$employeeBank || !$companyBank) {
    //         throw new \Exception("Incomplete bank details for payroll transaction.");
    //     }

    //     $amount = $payroll->total_amount;

    //     if ($companyBank->saldo < $amount) {
    //         throw new \Exception("Insufficient balance in company account.");
    //     }

    //     // Kurangi saldo perusahaan
    //     $companyBank->saldo -= $amount;
    //     $companyBank->save();

    //     // Tambahkan saldo karyawan
    //     $employeeBank->saldo += $amount;
    //     $employeeBank->save();
    // }
}
