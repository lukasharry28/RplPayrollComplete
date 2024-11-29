<?php

use App\Tunjangan;
use Illuminate\Database\Seeder;

class TunjanganSeeder extends Seeder
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
                'title' => 'Tunjangan Kesehatan',
                'rate_amount' => 500000,
            ],
            [
                'title' => 'Tunjangan Transportasi',
                'rate_amount' => 200000,
            ],
            [
                'title' => 'Tunjangan Keluarga',
                'rate_amount' => 300000,
            ],
            [
                'title' => 'Tunjangan Makan + Kesehatan + Transportasi + Keluarga',
                'rate_amount' => 1000000,
            ],
            [
                'title' => 'Tunjangan Makan + Kesehatan + Transportasi + Anak 1 Tanggungan + Keluarga',
                'rate_amount' => 1150000,
            ],
            [
                'title' => 'Tunjangan Makan + Kesehatan + Transportasi + Anak 2 Tanggungan + Keluarga',
                'rate_amount' => 1300000,
            ],
            [
                'title' => 'Tunjangan Makan + Kesehatan + Transportasi + Anak >=3 Tanggungan + Keluarga',
                'rate_amount' => 1450000,
            ],
        ];

        $count = 0;
        foreach ($datas as $key => $data) {
            Tunjangan::create($data);
            $count++;
        }

        $this->command->info('Inserted ' . $count . ' Tunjangan.');
    }
}
