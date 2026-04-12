<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder untuk accessories
        $this->call(AccessorySeeder::class);
        
        // Tidak perlu membuat user test karena akan dibuat via registrasi dari frontend
    }
}