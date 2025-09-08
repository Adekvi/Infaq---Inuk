<?php

namespace Database\Seeders\User;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = [
            [
                'id' => 1,
                'username' => 'superadmin',
                'no_hp' => '08788899922',
                'password' => bcrypt('1'),
                'role' => 'superadmin',
            ],
            // [
            //     'id' => 2,
            //     'id_setting' => '4',
            //     'username' => 'adminkabupaten',
            //     'no_hp' => '088866090204',
            //     'password' => bcrypt('1'),
            //     'role' => 'admin_kabupaten',
            // ],
            // [
            //     'id' => 3,
            //     'id_setting' => '5',
            //     'username' => 'adminkecamatan',
            //     'no_hp' => '089523324482',
            //     'password' => bcrypt('1'),
            //     'role' => 'admin_kecamatan',
            // ]
        ];

        foreach ($admin as $key => $value) {
            User::create($value);
        }
    }
}
