<?php
use Illuminate\Database\Seeder;
use App\Admin;
use Illuminate\Support\Facades\Hash;

class AdminsSeeder extends Seeder
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
                'username' => 'super_admin',
                'role' => 'SuperAdmin',
                'email' => 'superadmin@gmail.com',
                'image' => 'superAdmin.jpg',
                'password' => Hash::make('superadmin123'),
            ],

            [
                'username' => 'admin_payroll',
                'role' => 'AdminPayroll',
                'email' => 'adminpayroll@gmail.com',
                'image' => 'superPayroll.jpg',
                'password' => Hash::make('adminpayroll123'),
            ],

            [
                'username' => 'admin',
                'role' => 'Admin',
                'email' => 'admin@gmail.com',
                'image' => 'adminKantor.jpg',
                'password' => Hash::make('adminperusahan123'),
            ]
        ];

        $count = 0;
        foreach ($datas as $key => $data) {
            Admin::create($data);
            $count++;
        }
        $this->command->info('Inserted'.$count.' Admin.');
    }
}
