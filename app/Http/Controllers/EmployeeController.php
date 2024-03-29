<?php

namespace App\Http\Controllers;

use Throwable;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\Document;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\DocumentEmployee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        // Ottieni i parametri di ordinamento e direzione
        $sortBy = $request->input('sortBy', 'default');
        $direction = $request->input('direction', 'asc');
        $searchTerm = $request->input('employeeSearch');
            
        $columnTitles = [
            ['text' => 'Nome', 'sortBy' => 'name'],
            'Codice Fiscale',
            'Ruolo',
            'Documenti',
            'Modifica',
            'Elimina'
        ];
    
        $routeName = 'dashboard.employees.index';
    
        // Costruisci la query di base con le relazioni
        $queryBuilder = Employee::with(['documents', 'roles']);
    
        // Aggiungi la condizione di ricerca se un parametro di ricerca è presente
        if ($searchTerm) {
            $queryBuilder->where('employees.name', 'like', '%' . $searchTerm . '%')
                ->orWhere('surname', 'LIKE', "%$searchTerm%")
                ->orWhere('fiscal_code', 'LIKE', "%$searchTerm%")
                ->orWhere('birthday', 'LIKE', "%$searchTerm%")
                ->orWhere('address', 'LIKE', "%$searchTerm%")
                ->orWhere('email', 'LIKE', "%$searchTerm%")
                ->orWhere('email_work', 'LIKE', "%$searchTerm%")
                ->orWhere('phone', 'LIKE', "%$searchTerm%")
                ->orWhereHas('roles', function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', "%$searchTerm%");
                })
                ->orWhereHas('documents', function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', "%$searchTerm%");
                });
        }
    
        $queryBuilder->when($sortBy == 'name', function ($query) use ($direction) {
            $query->orderBy('employees.name', $direction);
        });
        
        // Paginazione con i parametri di ricerca
        $employees = $queryBuilder->paginate(25)->appends([
            'sortBy' => $sortBy,
            'direction' => $direction,
            'employeeSearch' => $searchTerm,
        ]);
    
        // Restituisci i dati alla vista
        return view('dashboard.employees.index', [
            'employees' => $employees,
            'sortBy' => $sortBy,
            'direction' => $direction,
            'routeName' => $routeName,
            'columnTitles' => $columnTitles,
        ]);
    }
    

    
    
    
    
    public function create()
    {
        $roles = Role::with('documents')->get();
        $documents = Document::all();
        
        return view('dashboard.employees.create', compact('roles', 'documents'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'documents.*' => 'required|file|mimes:pdf|max:2048', // Accetta solo file PDF
        ], [
            'documents.*.required' => __("Devi caricare tutti i documenti."),
            'documents.*.file' => __("Devi caricare un file."),
            'documents.*.mimes' => __("Puoi caricare solo formati PDF."),
            'documents.*.max' => __("Dimensione max 2mb.")
        ]);
        
        // Crea un nuovo Employee
        $employee = Employee::create([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'fiscal_code' => $request->input('fiscal_code'),
            'birthday' => $request->input('birthday'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'email_work' => $request->input('email_work'),

        ]);
        
        // Aggiungi ruolo associato
        $roleId = $request->input('role');
        $employee->roles()->sync([$roleId]);
        
        // Aggiungi documenti associati con i dettagli
        $role = Role::with('documents')->find($roleId);
        
        foreach ($request->file('documents', []) as $index => $documentFile) {
            $documentName = $request->input('document_names')[$index] ?? null;
        
            // Cerca il documento corrispondente al nome e al ruolo
            $documentModel = $role->documents->firstWhere('name', $documentName);
        
            if ($documentModel && $documentFile->isValid()) {
                // Ottieni l'estensione del file
                $ext = $documentFile->extension();
        
                // Genera il nome personalizzato combinando nome e cognome del dipendente, nome del documento e data e ora correnti formattate
                $customName = $request->input('name') . '_' . $request->input('surname') . '_' . $documentName . '_' . now()->format('d_m_Y_H_i') . '.' . $ext;
        
                // Salva il file con il nome personalizzato
                $pdfPath = $documentFile->storeAs('Dipendenti', $customName, 'public');
        
                // Collega il documento all'employee con i dettagli aggiuntivi
                $employee->documents()->attach($documentModel->id, [
                    'pdf_path' => $pdfPath,
                    'expiry_date' => $request->input('expiry_dates')[$index],
                ]);
            }
        }
        
        
        
        $employee->user()->associate(Auth::user());
    
        $employee->save();
        
        return redirect()->route('dashboard.employees.index')->with('success', 'Dipendente aggiunto con successo!');
    }
    
    
    public function show($id)
    {
        $employee = Employee::with(['documents', 'roles'])->findOrFail($id);
        return view('dashboard.employees.show', compact('employee'));
    }
    
    public function edit(Employee $employee)
    {
        // Carica i ruoli
        $roles = Role::all();
    
        // Recupera tutti i documenti associati al dipendente
        $documents = $employee->documents;
    
        return view('dashboard.employees.edit', compact('employee', 'roles', 'documents'));
    }
    
    
    
    public function update(Request $request, Employee $employee)
    {
    
        // Aggiorna i campi dell'utente
        $employee->update([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'fiscal_code' => $request->input('fiscal_code'),
            'birthday' => $request->input('birthday'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'email_work' => $request->input('email_work'),
        ]);
    
        foreach ($request->input('document_ids', []) as $key => $documentId) {
            $document = Document::find($documentId);
            
            if ($document && $employee->documents->contains($document)) {
                // Verifica che il documento sia associato all'utente
        
                // Aggiorna i dati del documento se necessario
                $employee->documents()->updateExistingPivot($documentId, [
                    'expiry_date' => $request->input("expiry_dates.$key"),
                    // Altri campi del documento, se necessario
                ]);
        
                // Aggiorna il file del documento solo se è stato fornito
                if ($request->hasFile("documentEmployees.$key.pdf") && $request->file("documentEmployees.$key.pdf")->isValid()) {
                    // Ottieni l'estensione del file
                    $ext = $request->file("documentEmployees.$key.pdf")->extension();
        
                    // Genera il nome personalizzato combinando nome e cognome del dipendente, nome del documento e data e ora correnti formattate
                    $customName = $employee->name . '_' . $employee->surname . '_' . $document->name . '_' . now()->format('d_m_Y_H_i') . '.' . $ext;
        
                    // Salva il file con il nome personalizzato
                    $pdfPath = $request->file("documentEmployees.$key.pdf")->storeAs('Dipendenti', $customName, 'public');
        
                    // Aggiorna il percorso del file del documento
                    $employee->documents()->updateExistingPivot($documentId, [
                        'pdf_path' => $pdfPath,
                    ]);
                }
            } else {
                // Documento non trovato o non associato all'utente
                // Puoi aggiungere del codice di gestione degli errori o di registrazione qui
            }
        }
        
        $employee->updated_by = Auth::user()->id;
        
        $employee->save();
        
        return redirect()->route('dashboard.employees.index')->with('success', 'Dipendente aggiornato con successo.');
    }        
    
    public function destroy(Employee $employee)
    {
        $employee->delete();
        
        return redirect()->route('dashboard.employees.index')->with('success', 'Dipendente eliminato con successo!');
    }
}
