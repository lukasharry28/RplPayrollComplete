<?php

use App\Pajak;
use Illuminate\Database\Seeder;
use App\Bank;
use Illuminate\Support\Facades\Hash;

class PajakSeeder extends Seeder
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
                'title' => 'Pajak Penghasilan (PPh) 21',
                'tax_amount' => 500000,
            ],
            [
                'title' => 'Pajak Pertambahan Nilai (PPN)',
                'tax_amount' => 100000,
            ],
            [
                'title' => 'Pajak Penghasilan (PPh) Badan',
                'tax_amount' => 1500000,
            ],
            [
                'title' => 'Pajak Bumi dan Bangunan (PBB)',
                'tax_amount' => 300000,
            ],
            [
                'title' => 'Pajak Kendaraan Bermotor (PKB)',
                'tax_amount' => 200000,
            ]
        ];

        $count = 0;
        foreach ($datas as $key => $data) {
            Pajak::create($data);
            $count++;
        }
        $this->command->info('Inserted'.$count.' Pajak.');
    }
}
