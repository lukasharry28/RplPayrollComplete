<?php

use App\Rekening;
use Illuminate\Database\Seeder;
use App\Bank;
use Illuminate\Support\Facades\Hash;

class RekeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            //Perusahan
            [
                'no_rekening' => '90648539',
                'nama_pemilik' => 'PT. Miaw Payroll',
                'rekening_name' => 'Rekening Utama',
                'type_rekening' => 'rekening perusahan',
                'saldo' => 409654237904,
                'bank_id' => 1,
            ],

            //Employee
            [
                'no_rekening' => '24645314',
                'nama_pemilik' => 'Lukas Purwanto',
                'rekening_name' => 'Rekening Tabungan',
                'type_rekening' => 'rekening pegawai',
                'saldo' => 6547355,
                'bank_id' => 1,
            ],

            [
                'no_rekening' => '78531520',
                'nama_pemilik' => 'Angela Pramesti',
                'rekening_name' => 'Rekening Tabungan',
                'type_rekening' => 'rekening pegawai',
                'saldo' => 9623563,
                'bank_id' => 4,
            ],

            [
                'no_rekening' => '43019718',
                'nama_pemilik' => 'Sewi Santika',
                'rekening_name' => 'Rekening Usaha',
                'type_rekening' => 'rekening pegawai',
                'saldo' => 12351345,
                'bank_id' => 2,
            ],

            [
                'no_rekening' => '10977928',
                'nama_pemilik' => 'Ryan Saputra',
                'rekening_name' => 'Rekening Gaji',
                'type_rekening' => 'rekening pegawai',
                'saldo' => 7523414,
                'bank_id' => 3,
            ],

            [
                'no_rekening' => '61022844',
                'nama_pemilik' => 'Aditya Wijaya',
                'rekening_name' => 'Rekening Tabungan',
                'type_rekening' => 'rekening pegawai',
                'saldo' => 5424562,
                'bank_id' => 5,
            ],

            [
                'no_rekening' => '12008724',
                'nama_pemilik' => 'Siska Rahmawati',
                'rekening_name' => 'Rekening Gaji',
                'type_rekening' => 'rekening pegawai',
                'saldo' => 8635231,
                'bank_id' => 1,
            ],

            [
                'no_rekening' => '19005714',
                'nama_pemilik' => 'Pradipta Zeus',
                'rekening_name' => 'Rekening Gaji',
                'type_rekening' => 'rekening pegawai',
                'saldo' => 9834529,
                'bank_id' => 5,
            ],

            [
                'no_rekening' => '19005713',
                'nama_pemilik' => 'Lim Mike',
                'rekening_name' => 'Rekening Gaji',
                'type_rekening' => 'rekening pegawai',
                'saldo' => 9834529,
                'bank_id' => 1,
            ],
        ];

        $count = 0;
        foreach ($datas as $key => $data) {
            Rekening::create($data);
            $count++;
        }
        $this->command->info('Inserted'.$count.' Rekening.');
    }
}
