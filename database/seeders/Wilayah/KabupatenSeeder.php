<?php

namespace Database\Seeders\Wilayah;

use App\Models\Master\Wilayah\Db_kabupaten;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KabupatenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 3319,
                'nama_kabupaten' => 'KABUPATEN KUDUS',
            ]
        ];

        foreach ($data as $key => $value) {
            Db_kabupaten::create($value);
        }
    }
}
