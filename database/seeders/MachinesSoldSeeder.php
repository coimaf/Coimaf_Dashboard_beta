<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\MachinesSold;
use App\Models\WarrantyType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MachinesSoldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warrantyTypes = WarrantyType::all();
        $users = User::all();

        foreach (range(1, 100) as $index) {
            MachinesSold::create([
                'model' => 'Modello ' . $index,
                'brand' => 'Marca ' . $index,
                'serial_number' => 'SN' . $index,
                'sale_date' => Carbon::now()->subDays(rand(1, 365)), // Data di vendita casuale nell'ultimo anno
                'old_buyer' => 'Vecchio acquirente ' . $index,
                'buyer' => 'Acquirente ' . $index,
                'warranty_expiration_date' => Carbon::now()->addDays(rand(1, 365)), // Data di scadenza della garanzia casuale nell'anno successivo
                'warranty_type_id' => $warrantyTypes->random()->id,
                'registration_date' => Carbon::now()->subDays(rand(1, 365)), // Data di registrazione casuale nell'ultimo anno
                'delivery_ddt' => 'DDT' . $index,
                'notes' => 'Note per la macchina venduta ' . $index,
                'user_id' => $users->random()->id,
                'updated_by' => $users->random()->name,
            ]);
        }
    }
}
