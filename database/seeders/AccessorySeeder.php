<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accessory;

class AccessorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    Accessory::insert([
        ['name' => 'Topi Sulap', 'description' => 'Keren dan Elegan', 'price' => 120, 'icon' => '🎩'],
        ['name' => 'Kacamata Keren', 'description' => 'Bikin makin stylish', 'price' => 80, 'icon' => '👓'],
        ['name' => 'Kalung Emas', 'description' => 'Berkilau dan mewah', 'price' => 200, 'icon' => '📿'],
        ['name' => 'Bando Bunga', 'description' => 'Ceria dan imut', 'price' => 60, 'icon' => '🌸'],
    ]);
}
}