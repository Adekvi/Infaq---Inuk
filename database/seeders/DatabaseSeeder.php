<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Master\SettingSeeder;
use Database\Seeders\User\UserSeeder;
use Database\Seeders\Wilayah\KabupatenSeeder;
use Database\Seeders\Wilayah\KecamatanSeeder;
use Database\Seeders\Wilayah\KelurahanSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            UserSeeder::class,
            KabupatenSeeder::class,
            KecamatanSeeder::class,
            KelurahanSeeder::class,
        ]);
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
