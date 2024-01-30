<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Deadline;
use Illuminate\Database\Seeder;
use App\Models\DocumentDeadline;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DocumentDeadlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deadlines = Deadline::all();

        foreach ($deadlines as $deadline) {
            // Generare un numero casuale di documenti per ogni scadenza
            $numDocuments = rand(1, 5);

            // Creare documenti di esempio per la scadenza corrente
            for ($i = 0; $i < $numDocuments; $i++) {
                // Genera un identificatore univoco per il documento
                $uniqueDocumentId = $deadline->id * 100 + $i;

                DocumentDeadline::create([
                    'name' => 'Documento ' . $uniqueDocumentId . ' di ' . $deadline->name,
                    'pdf_path' => 'path/al/pdf/documento_' . $uniqueDocumentId . '.pdf',
                    'expiry_date' => Carbon::now()->addDays(rand(1, 365)), // Scadenza casuale entro un anno dalla data attuale
                    'deadline_id' => $deadline->id,
                ]);
            }
        }
    }
}
