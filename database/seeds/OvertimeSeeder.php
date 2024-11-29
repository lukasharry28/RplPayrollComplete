<?php

use App\Overtime;
use App\Employee;
use Illuminate\Database\Seeder;

class OvertimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'title' => "First Overtime for last check",
                'rate_amount_hourse' => 50000, // Gaji per jam
                'work_hours' => 2, // 2 jam lembur
                'employee_id' => Employee::first()->id, // Menggunakan ID karyawan pertama
                'date' => "2021-04-01",
                'description' => "On this day we are schedule first overtime for employees.",
                'total_amount' => 100000.00, // rate_amount_hourse * work_hours
            ],
            [
                'title' => "Second Overtime for last check",
                'rate_amount_hourse' => 55000, // Gaji per jam
                'work_hours' => 3, // 3 jam lembur
                'employee_id' => Employee::where("id",2)->first()->id, // Menggunakan ID karyawan kedua
                'date' => "2021-04-06",
                'description' => "On this day we are schedule second overtime for employees.",
                'total_amount' => 165000.00, // rate_amount_hourse * work_hours
            ],
            [
                'title' => "Third Overtime for last check",
                'rate_amount_hourse' => 60000, // Gaji per jam
                'work_hours' => 4, // 4 jam lembur
                'employee_id' => Employee::where("id",3)->first()->id, // Menggunakan ID karyawan ketiga
                'date' => "2021-04-10",
                'description' => "On this day we are schedule third overtime for employees.",
                'total_amount' => 240000, // rate_amount_hourse * work_hours
            ],
            [
                'title' => "Fourth Overtime for last check",
                'rate_amount_hourse' => 65000, // Gaji per jam
                'work_hours' => 5, // 5 jam lembur
                'employee_id' => Employee::where("id",4)->first()->id, // Menggunakan ID karyawan keempat
                'date' => "2021-04-14",
                'description' => "On this day we are schedule fourth overtime for employees.",
                'total_amount' => 325000, // rate_amount_hourse * work_hours
            ],
        ];

        $count = 0;
        foreach ($datas as $key => $data) {
            Overtime::create($data);
            $count++;
        }

        $this->command->info('Inserted ' . $count . ' Overtimes.');
    }
}
