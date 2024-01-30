<?php

namespace Database\Seeders;

use App\Models\Technician;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TechnicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Technician::create(['name' => 'Mario', 'surname' => 'Rossi']);
        Technician::create(['name' => 'Giuseppe', 'surname' => 'Verdi']);
    }
}
