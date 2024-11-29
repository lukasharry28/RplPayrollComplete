<?php
use App\Deduction;
use Illuminate\Database\Seeder;

class DeductionSeeder extends Seeder
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
    			'name' => "Standard Deduction",
                'slug' => "standart-deduction",
    			'amount' => 600000,
    			'description' => "Alpa ",
    		],
            [
    			'name' => "Pensiun Deduction",
                'slug' => "dana-pensiun",
    			'amount' => 150000,
    			'description' => "Uang Pensiun ",
    		],
    		[
    			'name' => "Medical Insurance Deduction",
                'slug' => "medical-insurance",
    			'amount' => 200000,
    			'description' => "Asuransi Perusahaan ",
    		],

    	];

    	$count = 0;
    	foreach ($datas as $key => $data) {
    		Deduction::create($data);
    		$count++;
    	}
    	$this->command->info('Inserted '.$count.' Deductions.');
    }
}
