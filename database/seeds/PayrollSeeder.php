<?php

use Illuminate\Database\Seeder;
use App\Payroll;
use App\Employee;
use App\Company;
use App\Payrollschedule;

class PayrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Bersihkan tabel Payroll sebelum seeding
        Payroll::truncate();

        // Pastikan data tersedia di tabel terkait
        $employees = Employee::all();
        $companies = Company::all();
        $schedules = Payrollschedule::all();

        if ($employees->isEmpty() || $companies->isEmpty() || $schedules->isEmpty()) {
            $this->command->error('Ensure Employees, Companies, and PayrollSchedules tables are seeded first.');
            return;
        }

        foreach ($employees as $employee) {
            // Ambil relasi untuk deduction, pajak, dan tunjangan dari Employee
            $deduction = $employee->deduction; // Relasi ke Deduction
            $pajak = $employee->pajak; // Relasi ke Pajak
            $tunjangan = $employee->tunjangan; // Relasi ke Tunjangan

            // Hindari duplikasi payroll untuk employee yang sama
            if (!Payroll::where('employee_id', $employee->id)->exists()) {
                $payroll = Payroll::create([
                    'employee_id' => $employee->id,
                    'company_id' => $companies->random()->company_id, // Ambil ID dari perusahaan acak
                    'date' => now()->subDays(rand(1, 30)), // Tanggal acak dalam 30 hari ke belakang
                    'payroll_status' => 'Pending', // Default status
                    'payschedule_id' => $schedules->random()->payschedule_id, // Ambil ID dari jadwal acak
                    'deduction' => $deduction ? $deduction->amount : 0,
                    'pajak' => $pajak ? $pajak->tax_amount : 0,
                    'tunjangan' => $tunjangan ? $tunjangan->rate_amount : 0,
                ]);

                // Hitung total_amount berdasarkan logika bisnis
                $payroll->total_amount = max(0, $payroll->tunjangan - $payroll->deduction - $payroll->pajak);

                // Simpan perubahan ke payroll
                $payroll->save();
            }
        }

        $this->command->info('Inserted payroll records for employees.');
    }
}
