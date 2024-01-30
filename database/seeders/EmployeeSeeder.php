<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use App\Models\Role;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all();
        $users = User::all();
        $faker = Factory::create();

        // Creazione di 10 dipendenti di esempio
        foreach (range(1, 100) as $index) {
            $employee = Employee::create([
                'name' => $faker->name,
                'surname' => $faker->lastname,
                'fiscal_code' => 'ABCD' . $index . 'EFGH' . $index,
                'birthday' => Carbon::now()->subYears(rand(20, 60))->subDays(rand(0, 365)),
                'phone' => '123456789' . $index,
                'address' => 'Indirizzo ' . $index,
                'email' => 'dipendente' . $index . '@azienda.com',
                'email_work' => 'work@dipendente' . $index . '@azienda.com',
                'user_id' => $users->random()->id,
                'updated_by' => $users->random()->name,
            ]);

            $randomRole = $roles->random();
            $employee->roles()->attach($randomRole->id);
        }
    }
}
