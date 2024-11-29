<?php

use Illuminate\Database\Seeder;
use App\Company;
use App\PayrollSchedule;

class PayrollScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->command->error('No companies found. Please seed the companies table first.');
            return;
        }

        $statuses = ['Confirmed', 'Failed', 'Progress'];

        foreach ($companies as $company) {
            PayrollSchedule::create([
                'company_id' => 1,
                'payroll_date' => '2024-12-17',
                'payroll_status' => 'Progress',
            ]);
        }

        $this->command->info('Inserted ' . $companies->count() . ' payroll schedules.');
    }
}
