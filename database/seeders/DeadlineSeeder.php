<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\User;
use App\Models\Deadline;
use Illuminate\Database\Seeder;
use App\Models\DocumentDeadline;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DeadlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        foreach (range(1, 100) as $index) {
            $deadline = Deadline::create([
                'name' => 'Scadenza numero ' . $index,
                'description' => 'Descrizione della scadenza numero ' . $index,
                'updated_by' => $users->random()->name,
                'user_id' => $users->random()->id,
            ]);

            // Associazione di tag casuali
            $tags = Tag::inRandomOrder()->limit(rand(1, 3))->get();
            $deadline->tags()->attach($tags);

            // Creazione di documenti scaduti o in scadenza
            foreach (range(1, rand(1, 3)) as $documentIndex) {
                $expiryDate = Carbon::now()->addDays(rand(-30, 30)); // Genera una data di scadenza casuale nei prossimi 30 giorni
                DocumentDeadline::create([
                    'deadline_id' => $deadline->id,
                    'name' => 'Documento ' . $documentIndex,
                    'expiry_date' => $expiryDate,
                ]);
            }
        }
    }
}
