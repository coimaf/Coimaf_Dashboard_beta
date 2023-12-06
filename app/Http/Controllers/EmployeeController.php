<?php

namespace App\Http\Controllers;

use Throwable;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\Document;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $columnTitles = ["Nome", "Codice Fiscale", "Ruolo", "Documenti", "Modifica", "Elimina"];
        $employees = Employee::with('documents')->get();
        $documentStatuses = $this->getDocumentStatuses($employees);
        
        return view('dashboard.employees.index', [
            'columnTitles' => $columnTitles,
            'employees' => $employees,
            'tooltipText' => $documentStatuses['tooltipText'],
            'icon' => $documentStatuses['icon'],
        ]);
    }
    
    public function create()
    {
        $roles = ['Ufficio', 'Operaio', 'Canalista', 'Frigorista'];
        $documentTypes = [
            'Ufficio' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica',],
            'Operaio' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica',],
            'Canalista' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica', 'Patente', 'Patente Carrelli', 'Patente PLE' , 'Lavori in quota'],
            'Frigorista' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica', 'Patente', 'Patente Carrelli', 'Patente PLE' ,],
        ];
        
        return view('dashboard.employees.create', compact('roles', 'documentTypes'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'fiscal_code' => 'required|string|max:255',
            'birthday' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'email_work' => 'email|max:255',
            'role' => 'required|in:Ufficio,Operaio,Canalista,Frigorista',
            'documents.*.pdf' => 'required|mimes:pdf|max:2048',
            'documents.*.expiry_date' => 'required|date',
        ]);
        
        $employee = Employee::create([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'fiscal_code' => $request->input('fiscal_code'),
            'birthday' => $request->input('birthday'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'email_work' => $request->input('email_work'),
            'role' => $request->input('role'),
        ]);
        
        foreach ($request->file('documents.*.pdf') as $key => $pdf) {
            $defaultName = $request->input("documents.$key.name");
            $expiryDate = $request->input("documents.$key.expiry_date");
            
            $pdfPath = $pdf->storeAs('pdf_documents', $defaultName . '.pdf', 'public');
            
            $employee->documents()->create([
                'name' => $defaultName,
                'pdf_path' => $pdfPath,
                'expiry_date' => Carbon::createFromFormat('Y-m-d', $expiryDate),
            ]);
        }
        
        return redirect()->route('dashboard.employees.index')->with('success', 'Complimenti! Hai aggiunto un nuovo Dipendente');
    }
    
    public function show($id)
    {
        $employee = Employee::with('documents')->findOrFail($id);
        return view('dashboard.employees.show', compact('employee'));
    }
    
    public function edit(Employee $employee)
    {
        $roles = ['Ufficio', 'Operaio', 'Canalista', 'Frigorista'];
        $documentTypes = [
            'Ufficio' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica',],
            'Operaio' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica',],
            'Canalista' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica', 'Patente', 'Patente Carrelli', 'Patente PLE' , 'Lavori in quota'],
            'Frigorista' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica', 'Patente', 'Patente Carrelli', 'Patente PLE' ,],
        ];
        
        return view('dashboard.employees.edit', compact('employee', 'roles', 'documentTypes'));
    }
    
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'fiscal_code' => 'required|string|max:255',
            'birthday' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'email_work' => 'email|max:255',
            'role' => 'required|in:Ufficio,Operaio,Canalista,Frigorista',
            'documents.*.pdf' => 'nullable|mimes:pdf|max:2048',
            'documents.*.expiry_date' => 'nullable|date',
        ]);
        
        $employee->update([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'fiscal_code' => $request->input('fiscal_code'),
            'birthday' => $request->input('birthday'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'email_work' => $request->input('email_work'),
            'role' => $request->input('role'),
        ]);
        
        $pdfs = $request->file('documents.*.pdf');
        
        if ($pdfs) {
            foreach ($pdfs as $key => $pdf) {
                $defaultName = $request->input("documents.$key.name");
                $expiryDate = $request->input("documents.$key.expiry_date");
                
                $pdfPath = $pdf ? $pdf->storeAs('pdf_documents', $defaultName . '.pdf', 'public') : $employee->documents[$key]->pdf_path;
                
                $employee->documents()->updateOrCreate(
                    ['name' => $defaultName],
                    [
                        'pdf_path' => $pdfPath,
                        'expiry_date' => Carbon::createFromFormat('Y-m-d', $expiryDate),
                        ]
                    );
                }
            }
            
            $documents = $request->input('documents');
            
            if ($documents) {
                foreach ($documents as $key => $documentData) {
                    $defaultName = $documentData['name'];
                    $expiryDate = $documentData['expiry_date'];
                    
                    $document = $employee->documents()->where('name', $defaultName)->first();
                    
                    if ($document) {
                        $document->update([
                            'expiry_date' => Carbon::createFromFormat('Y-m-d', $expiryDate),
                        ]);
                    }
                }
            }
            
            return redirect()->route('dashboard.employees.index')->with('success', 'Dipendente aggiornato con successo!');
        }
        
        public function destroy(Employee $employee)
        {
            $employee->delete();
            
            return redirect()->route('dashboard.employees.index')->with('success', 'Dipendente eliminato con successo!');
        }
        
        private function getDocumentStatuses($employees)
        {
            $status = 'green'; // Impostare lo stato predefinito a verde (nessun problema)
            $icon = '';
            $tooltipText = '';
            $expiredDocuments = collect();
            $expiringDocuments = collect();
            foreach ($employees as $employee) {
                foreach ($employee->documents as $document) {
                    $expiryDate = Carbon::parse($document->expiry_date);
                    
                    if ($expiryDate->isPast()) {
                        $expiredDocuments->push($document->name);
                        $status = 'red'; // Imposta lo stato a rosso se c'è almeno un documento scaduto
                    } elseif ($expiryDate->diffInDays(now()) <= 60 && $status !== 'red') {
                        // Imposta lo stato a giallo solo se non è già rosso
                        $status = 'yellow'; 
                        $expiringDocuments->push($document->name);
                    }
                }
                
                $icon = match($status) {
                    'red' => '<i class="bi bi-dash-circle-fill text-danger fs-3"></i>',
                    'yellow' => '<i class="bi bi-exclamation-circle-fill text-warning fs-3"></i>',
                    default => "<i class='bi bi-check-circle-fill text-success fs-3'></i>",
                };
                
                $tooltipText = '';
                
                if ($expiredDocuments->isNotEmpty()) {
                    $tooltipText .= 'Scaduti: ' . implode(', ', $expiredDocuments->toArray()) . "\n";
                }
                
                if ($expiringDocuments->isNotEmpty()) {
                    $tooltipText .= 'Stanno per scadere: ' . implode(', ', $expiringDocuments->toArray()) . "\n";
                }
            }
            return compact('icon', 'tooltipText');
        }
    }
    