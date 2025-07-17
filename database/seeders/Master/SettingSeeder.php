<?php

namespace Database\Seeders\Master;

use App\Models\Master\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = [
            [
                'id' => 1,
                'namasetting' => 'Ketua',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'namasetting' => 'Sekretaris',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'namasetting' => 'Bendahara',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'namasetting' => 'Admin Kabupaten',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'namasetting' => 'Admin Kecamatan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 6,
                'namasetting' => 'Kolektor',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($setting as $key => $value) {
            Setting::create($value);
        }
    }
}
