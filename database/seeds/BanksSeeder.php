<?php

use Illuminate\Database\Seeder;
use App\Bank;

class BanksSeeder extends Seeder
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
                'bank_name' => 'Bank Central Asia',
                'image_name' => 'bca.png'
            ],

            [
                'bank_name' => 'Bank Negara Indonesia',
                'image_name' => 'bni.png'
            ],

            [
                'bank_name' => 'Bank Rakyat Indonesia',
                'image_name' => 'bri.png'
            ],

            [
                'bank_name' => 'Bank Danamon',
                'image_name' => 'danamon.png'
            ],

            [
                'bank_name' => 'Bank Mandiri',
                'image_name' => 'mandiri.png'
            ],

            [
                'bank_name' => 'Bank Mayapada',
                'image_name' => 'mayapada.png'
            ]
        ];

        $count = 0;
        foreach ($datas as $key => $data) {
            Bank::create($data);
            $count++;
        }
        $this->command->info('Inserted'.$count.' Bank.');
    }
}
