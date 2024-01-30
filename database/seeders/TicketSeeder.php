<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Technician;
use App\Models\MachinesSold;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $technicians = Technician::all();
        $machines = MachinesSold::all();
        $faker = Factory::create();

        foreach (range(1, 100) as $index) {
            Ticket::create([
                'updated_by' => $users->random()->name,
                'user_id' => $users->random()->id,
                'title' => 'Ticket numero ' . $index,
                'description' => 'Descrizione per il ticket numero ' . $index,
                'notes' => 'Risolto il problema per il ticket numero ' . $index,
                'descrizione' => $faker->name . ' ' . $faker->lastName,
                'cd_cf' => 'CF' . rand(1000000000, 9999999999),
                'intervention_date' => now()->addDays(rand(1, 30)),
                'machine_model_id' => $machines->random()->id,
                'machine_sold_id' => $machines->random()->id,
                'closed' => Carbon::now()->subDays(rand(1, 365)),
                'status' => Ticket::getStatusOptions()[rand(0, count(Ticket::getStatusOptions()) - 1)],
                'priority' => Ticket::getPriorityOptions()[rand(0, count(Ticket::getPriorityOptions()) - 1)],
                'technician_id' => $technicians->random()->id,
            ]);
        }
    }
}
