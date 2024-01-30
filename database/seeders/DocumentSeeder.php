<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Document;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        // Creazione di 10 documenti di esempio
        for ($i = 1; $i <= 10; $i++) {
            Document::create([
                'name' => 'Documento ' . $i,
                'pdf_file' => 'path/to/pdf/document_' . $i . '.pdf', // Sostituisci con il percorso reale
            ]);
        }
    }
}
