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
            [
                'id' => 2,
                'username' => 'adminkecamatan',
                'no_hp' => '08577799900',
                'password' => bcrypt('1'),
                'role' => 'admin_kecamatan',
            ],
            [
                'id' => 3,
                'username' => 'adminkabupaten',
                'no_hp' => '08644499911',
                'password' => bcrypt('1'),
                'role' => 'admin_kabupaten',
            ]
        ];

        foreach ($admin as $key => $value) {
            User::create($value);
        }
    }
}
