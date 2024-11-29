<?php

use Illuminate\Database\Seeder;
use App\Rekening;
use App\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pastikan ada rekening perusahaan
        $companyRekening = Rekening::where('type_rekening', 'rekening perusahan')->first();

        // Buat data perusahaan
        Company::create([
            'company_name' => 'PT. Miaw Payroll',
            'phone' => '081234567890',
            'email' => 'info@miaw.ac.id',
            'address' => 'Jl. Raya Perusahaan No. 123, Kota Yogyakarta',
            'id_rekening' => $companyRekening ? $companyRekening->id_rekening : null,
        ]);

        $this->command->info('Company data inserted successfully.');
    }
}
