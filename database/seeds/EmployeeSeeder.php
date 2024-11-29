<?php

use App\Employee;
use App\Rekening;
use App\Pajak;
use App\Tunjangan;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ambil data
        $pajakList = Pajak::pluck('pajak_id')->toArray(); // Ambil semua id pajak
        $tunjanganList = Tunjangan::pluck('tunjangan_id')->toArray(); // Ambil semua id tunjangan

        $datas = [
            [
                'employee_id' => 'EMP0001',
                'nik' => '7934567890123456',
                'first_name' => "Pradipta",
                'last_name' => "Zeus",
                'gender' => "male",
                'tgl_lahir' => "2001-04-10",
                'tmp_lahir' => "Solo",
                'agama' => "Islam",
                'gol_darah' => "O",
                'status_nikah' => "belum menikah",
                'phone' => "0888-888-999",
                'email' => "dipta@ggmail.com",
                'address' => "Jalan Solo KM 14",
                'status_kerja' => "Tetap",
                'deduction_id' => 1,
                'position_id' => 3,
                'schedule_id' => 2,
                'salary' => 3000000,
                'is_active' => 1,
                'id_rekening' => 8,
                'pajak_id' => $pajakList[array_rand($pajakList)], // Random pajak_id
                'tunjangan_id' => $tunjanganList[array_rand($tunjanganList)], // Random tunjangan_id
            ],
            [
                'employee_id' => 'EMP0002',
                'nik' => '27834567890123456',
                'first_name' => "Lukas",
                'last_name' => "Purwanto",
                'gender' => "male",
                'tgl_lahir' => "2005-05-23",
                'tmp_lahir' => "Bali",
                'agama' => "Kristen",
                'gol_darah' => "A",
                'status_nikah' => "belum menikah",
                'phone' => "0999-222-222",
                'email' => "lukas@ggmail.com",
                'address' => "Klaten, Bali",
                'status_kerja' => "Tetap",
                'deduction_id' => 1,
                'position_id' => 2,
                'schedule_id' => 3,
                'salary' => 5000000,
                'is_active' => 1,
                'id_rekening' => 2,
                'pajak_id' => $pajakList[array_rand($pajakList)],
                'tunjangan_id' => $tunjanganList[array_rand($tunjanganList)],
            ],
            [
                'employee_id' => 'EMP0003',
                'nik' => '3234567890123456',
                'first_name' => "Angela",
                'last_name' => "Pramesti",
                'gender' => "female",
                'tgl_lahir' => "1998-07-15",
                'tmp_lahir' => "Jakarta",
                'agama' => "Hindu",
                'gol_darah' => "B",
                'status_nikah' => "menikah",
                'phone' => "0881-555-678",
                'email' => "angela@ggmail.com",
                'address' => "Jakarta Barat, DKI Jakarta",
                'status_kerja' => "Tetap",
                'deduction_id' => 1,
                'position_id' => 1,
                'schedule_id' => 1,
                'salary' => 4500000,
                'is_active' => 1,
                'id_rekening' => 3,
                'pajak_id' => $pajakList[array_rand($pajakList)],
                'tunjangan_id' => $tunjanganList[array_rand($tunjanganList)],
            ],
            [
                'employee_id' => 'EMP0004',
                'nik' => '4234567890123456',
                'first_name' => "Dewi",
                'last_name' => "Santika",
                'gender' => "female",
                'tgl_lahir' => "1995-12-20",
                'tmp_lahir' => "Surabaya",
                'agama' => "Islam",
                'gol_darah' => "AB",
                'status_nikah' => "menikah",
                'phone' => "0811-123-456",
                'email' => "dewi@ggmail.com",
                'address' => "Surabaya, Jawa Timur",
                'status_kerja' => "Tetap",
                'deduction_id' => 1,
                'position_id' => 4,
                'schedule_id' => 4,
                'salary' => 6000000,

                'is_active' => 1,
                'id_rekening' => 4,
                'pajak_id' => $pajakList[array_rand($pajakList)],
                'tunjangan_id' => $tunjanganList[array_rand($tunjanganList)],
            ],
            [
                'employee_id' => 'EMP0005',
                'nik' => '5234567890123456',
                'first_name' => "Ryan",
                'last_name' => "Saputra",
                'gender' => "male",
                'tgl_lahir' => "2000-03-19",
                'tmp_lahir' => "Yogyakarta",
                'agama' => "Buddha",
                'gol_darah' => "O",
                'status_nikah' => "belum menikah",
                'phone' => "0819-888-111",
                'email' => "ryan@ggmail.com",
                'address' => "Bantul, Yogyakarta",
                'status_kerja' => "Tetap",
                'deduction_id' => 1,
                'position_id' => 3,
                'schedule_id' => 2,
                'salary' => 3500000,
                'is_active' => 1,
                'id_rekening' => 5,
                'pajak_id' => $pajakList[array_rand($pajakList)],
                'tunjangan_id' => $tunjanganList[array_rand($tunjanganList)],
            ],

            [
                'employee_id' => 'EMP0006',
                'nik' => '6234567890123456',
                'first_name' => "Aditya",
                'last_name' => "Wijaya",
                'gender' => "male",
                'tgl_lahir' => "1997-08-15",
                'tmp_lahir' => "Bandung",
                'agama' => "Islam",
                'gol_darah' => "A",
                'status_nikah' => "menikah",
                'phone' => "0822-555-777",
                'email' => "aditya@ggmail.com",
                'address' => "Cimahi, Bandung",
                'status_kerja' => "Tetap",
                'deduction_id' => 1,
                'position_id' => 2,
                'schedule_id' => 1,
                'salary' => 4000000,
                'is_active' => 1,
                'id_rekening' => 6,
                'pajak_id' => $pajakList[array_rand($pajakList)],
                'tunjangan_id' => $tunjanganList[array_rand($tunjanganList)],
            ],
            [
                'employee_id' => 'EMP0007',
                'nik' => '7234567890123456',
                'first_name' => "Siska",
                'last_name' => "Rahmawati",
                'gender' => "female",
                'tgl_lahir' => "1994-01-22",
                'tmp_lahir' => "Semarang",
                'agama' => "Kristen",
                'gol_darah' => "B",
                'status_nikah' => "menikah",
                'phone' => "0812-333-444",
                'email' => "siska@ggmail.com",
                'address' => "Tembalang, Semarang",
                'status_kerja' => "Tetap",
                'deduction_id' => 1,
                'position_id' => 4,
                'schedule_id' => 3,
                'salary' => 5000000,
                'is_active' => 1,
                'id_rekening' => 7,
                'pajak_id' => $pajakList[array_rand($pajakList)],
                'tunjangan_id' => $tunjanganList[array_rand($tunjanganList)],
            ]
        ];

        foreach ($datas as $data) {
            Employee::create($data);
        }

        $this->command->info('Inserted ' . count($datas) . ' Employees.');
    }
}
