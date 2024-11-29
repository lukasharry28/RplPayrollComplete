<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminsSeeder::class);
        $this->call(BanksSeeder::class);
        $this->call(RekeningSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(DeductionSeeder::class);
        $this->call(PajakSeeder::class);
        $this->call(TunjanganSeeder::class);
        $this->call(ScheduleSeeder::class);

        // Seeders for employee-related data
        $this->call(EmployeeSeeder::class);
        $this->call(OvertimeSeeder::class);
        $this->call(AttendanceSeeder::class);

        // Seeders for payroll-related data
        $this->call(PayrollScheduleSeeder::class);
        $this->call(PayrollSeeder::class);
    }
}
