<?php

namespace Database\Seeders\Wilayah;

use App\Models\Master\Wilayah\Db_kecamatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_kabupaten' => 3319,
                'id' => 331901,
                'nama_kecamatan' => 'KALIWUNGU',
                'status' => 'Aktif',
            ],
            [
                'id_kabupaten' => 3319,
                'id' => 331902,
                'nama_kecamatan' => 'KOTA KUDUS',
                'status' => 'Non-aktif',
            ],
            [
                'id_kabupaten' => 3319,
                'id' => 331903,
                'nama_kecamatan' => 'JATI',
                'status' => 'Non-aktif',
            ],
            [
                'id_kabupaten' => 3319,
                'id' => 331904,
                'nama_kecamatan' => 'UNDAAN',
                'status' => 'Non-aktif',
            ],
            [
                'id_kabupaten' => 3319,
                'id' => 331905,
                'nama_kecamatan' => 'MEJOBO',
                'status' => 'Non-aktif',
            ],
            [
                'id_kabupaten' => 3319,
                'id' => 331906,
                'nama_kecamatan' => 'JEKULO',
                'status' => 'Non-aktif',
            ],
            [
                'id_kabupaten' => 3319,
                'id' => 331907,
                'nama_kecamatan' => 'BAE',
                'status' => 'Non-aktif',
            ],
            [
                'id_kabupaten' => 3319,
                'id' => 331908,
                'nama_kecamatan' => 'GEBOG',
                'status' => 'Non-aktif',
            ],
            [
                'id_kabupaten' => 3319,
                'id' => 331909,
                'nama_kecamatan' => 'DAWE',
                'status' => 'Non-aktif',
            ]
        ];

        foreach ($data as $key => $value) {
            Db_kecamatan::create($value);
        }
    }
}
