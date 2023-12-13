<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Document;
use App\Models\Employee;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $roles = ['Ufficio', 'Operaio', 'Canalista', 'Frigorista'];
        $documentTypes = [
            'Ufficio' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica',],
            'Operaio' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica',],
            'Canalista' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica', 'Patente', 'Patente Carrelli', 'Patente PLE', 'Lavori in quota'],
            'Frigorista' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica', 'Patente', 'Patente Carrelli', 'Patente PLE',],
        ];

        return view('dashboard.settings.index', compact('documentTypes'));
    }

    public function create($role)
{
    $roles = Role::pluck('name'); // Recupera tutti i nomi dei ruoli dal database
        $documentTypes = [
            'Ufficio' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica'],
            'Operaio' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica'],
            'Canalista' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica', 'Patente', 'Patente Carrelli', 'Patente PLE', 'Lavori in quota'],
            'Frigorista' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica', 'Patente', 'Patente Carrelli', 'Patente PLE'],
        ];
        
        return view('dashboard.employees.create', compact('roles', 'documentTypes'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'pdf_path' => 'nullable|string',
        'expiry_date' => 'nullable|date',
        'role' => 'required|in:Ufficio,Operaio,Canalista,Frigorista',
    ]);

    // Crea un nuovo documento senza associarlo a un dipendente per ora
    $document = new Document([
        'name' => $request->input('name'),
        'pdf_path' => $request->input('pdf_path'),
        'expiry_date' => $request->input('expiry_date'),
    ]);

    // Salva il documento nel database
    $document->save();

    return redirect()->route('dashboard.settings.index')->with('success', 'Documento creato con successo.');
}
    
}
