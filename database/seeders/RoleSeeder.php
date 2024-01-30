<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleNames = ['Ufficio', 'Canalista', 'Frigorista', 'Operaio'];

        foreach ($roleNames as $roleName) {
            Role::create([
                'name' => $roleName,
            ]);
        }
    }
}
