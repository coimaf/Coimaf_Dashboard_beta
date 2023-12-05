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
            'documentStatuses' => $documentStatuses,
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
            'documents.*.image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
        
        foreach ($request->file('documents.*.image') as $key => $image) {
            $defaultName = $request->input("documents.$key.name");
            $expiryDate = $request->input("documents.$key.expiry_date");
            
            $imagePath = $image->store('document_images', 'public');
            
            $employee->documents()->create([
                'name' => $defaultName,
                'image' => $imagePath,
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
            'documents.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
    
    
        $images = $request->file('documents.*.image');
    
        if ($images) {
            foreach ($images as $key => $image) {
                $defaultName = $request->input("documents.$key.name");
                $expiryDate = $request->input("documents.$key.expiry_date");
    
                $imagePath = $image ? $image->store('document_images', 'public') : $employee->documents[$key]->image;
    
                $employee->documents()->updateOrCreate(
                    ['name' => $defaultName],
                    [
                        'image' => $imagePath,
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
        $statuses = [];
        
        foreach ($employees as $employee) {
            $status = 'green';
            
            foreach ($employee->documents as $document) {
                $expiryDate = Carbon::parse($document->expiry_date);
                
                if ($expiryDate->isPast()) {
                    $status = 'red';
                } elseif ($expiryDate->diffInDays(now()) <= 60) {
                    $status = 'yellow';
                }
            }
            
            $statuses[$employee->id] = $status;
        }
        
        return $statuses;
    }
}
