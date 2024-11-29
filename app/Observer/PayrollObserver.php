<?php

namespace App\Observers;

use App\{Payroll};

class PayrollObserver
{
    public function creating(Payroll $payroll)
    {
        // Hitung total amount sebelum disimpan
        $payroll->total_amount = $payroll->calculateTotalAmount();
    }

    public function updating(Payroll $payroll)
    {
        // Perbarui total amount saat payroll diperbarui
        $payroll->total_amount = $payroll->calculateTotalAmount();
    }

    public function created(Payroll $payroll)
    {
        // Logika tambahan setelah payroll berhasil dibuat
        $this->processPayrollTransaction($payroll);
    }

    public function saving(Payroll $payroll)
    {
        // Pastikan benefit karyawan dihitung
        $payroll->retrieveEmployeeBenefits();

         // Perbarui total amount berdasarkan perhitungan
        $payroll->total_amount = $payroll->calculateTotalAmount();
    }

    private function processPayrollTransaction(Payroll $payroll)
    {
        $employeeBank = $payroll->employee->rekening;
        $companyBank = $payroll->company->rekening;

        if (!$employeeBank || !$companyBank) {
            throw new \Exception("Incomplete bank details for payroll transaction.");
        }

        $amount = $payroll->total_amount;

        if ($companyBank->saldo < $amount) {
            throw new \Exception("Insufficient balance in company account.");
        }

        // Kurangi saldo perusahaan
        $companyBank->saldo -= $amount;
        $companyBank->save();

        // Tambahkan saldo karyawan
        $employeeBank->saldo += $amount;
        $employeeBank->save();
    }
}
