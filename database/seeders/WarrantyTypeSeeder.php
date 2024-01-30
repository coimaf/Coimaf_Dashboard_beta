<?php

namespace Database\Seeders;

use App\Models\WarrantyType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WarrantyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WarrantyType::create(['name' => 'Garanzia limitata']);
        WarrantyType::create(['name' => 'Garanzia estesa']);
        WarrantyType::create(['name' => 'Garanzia a vita']);
        WarrantyType::create(['name' => 'Garanzia Standard']);
    }
}
