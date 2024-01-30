<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Document;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use App\Models\DocumentEmployee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DocumentEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();
        $documents = Document::all();

        // Numero di collegamenti dipendente-documento da creare per ciascun dipendente
        $linksPerEmployee = 5;

        // Creazione dei collegamenti dipendente-documento
        foreach ($employees as $employee) {
            // Seleziona casualmente alcuni documenti per il dipendente corrente
            $selectedDocuments = $documents->random($linksPerEmployee);

            foreach ($selectedDocuments as $document) {
                // Genera una data di scadenza casuale
                $expiryDate = Carbon::now()->addDays(rand(1, 365));

                // Crea il collegamento tra il dipendente e il documento selezionato
                DocumentEmployee::create([
                    'employee_id' => $employee->id,
                    'document_id' => $document->id,
                    'pdf_path' => 'path/to/pdf/' . $document->name . '.pdf',
                    'expiry_date' => $expiryDate,
                ]);
            }
        }
    }
}
