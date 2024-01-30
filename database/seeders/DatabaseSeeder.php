<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\TagSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TicketSeeder;
use Database\Seeders\DocumentSeeder;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\TechnicianSeeder;
use Database\Seeders\MachinesSoldSeeder;
use Database\Seeders\WarrantyTypeSeeder;
use Database\Seeders\DocumentDeadlineSeeder;
use Database\Seeders\DocumentEmployeeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(WarrantyTypeSeeder::class);
        $this->call(TechnicianSeeder::class);
        $this->call(MachinesSoldSeeder::class);
        $this->call(TicketSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(DocumentDeadlineSeeder::class);
        $this->call(DeadlineSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(DocumentSeeder::class);
        $this->call(DocumentEmployeeSeeder::class);
    }
}
