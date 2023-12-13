<?php

namespace App\Http\Controllers;

use Throwable;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\DocumentEmployee;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sortBy', 'default');
        $direction = $request->input('direction', 'asc');
    
        $columnTitles = [
            ['text' => 'Nome', 'sortBy' => 'name'],
            'Codice Fiscale',
            'Ruolo',
            ['text' => 'Documenti', 'sortBy' => 'expiry_date'],
            'Modifica',
            'Elimina'
        ];
    
        $routeName = 'dashboard.employees.index';
    
        $query = Employee::with('documentEmployees');
    
        if ($sortBy == 'expiry_date') {
            // Utilizza una subquery per ottenere l'ID univoco degli Employee con la data di scadenza più recente
            $subquery = DocumentEmployee::selectRaw('employee_id, MAX(expiry_date) as latest_expiry_date')
                ->groupBy('employee_id');
    
            // Esegui la join basata sulla subquery
            $query->joinSub($subquery, 'latest_documents', function ($join) {
                $join->on('employees.id', '=', 'latest_documents.employee_id');
            })
            ->orderBy('latest_documents.latest_expiry_date', $direction)
            ->select('employees.*');
        } elseif ($sortBy == 'name') {
            $query->orderBy('employees.name', $direction);
        }
    
        $employees = $query->get();
    
        return view('dashboard.employees.index', [
            'columnTitles' => $columnTitles,
            'employees' => $employees,
            'sortBy' => $sortBy,
            'direction' => $direction,
            'routeName' => $routeName
        ]);
    }
    
    
    public function create()
    {
        $roles = Role::all();
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
            'documents.*.pdf' => 'required|mimes:pdf|max:2048',
            'documents.*.expiry_date' => 'required|date',
        ]);
        try {
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

        $roleId = $request->input('role');

        $role = Role::findOrFail($roleId);
        $employee->role()->associate($role);
        
        foreach ($request->file('documents') as $key => $pdfArray) {
            // Ottieni il singolo file dall'array
            $pdf = $pdfArray['pdf'];
        
            $defaultName = $request->input("documents.$key.name");
            $expiryDate = $request->input("documents.$key.expiry_date");
        
            $pdfPath = $pdf->storeAs('pdf_documents', $defaultName . '.pdf', 'public');
        
            $employee->documentEmployees()->create([
                'name' => $defaultName,
                'pdf_path' => $pdfPath,
                'expiry_date' => Carbon::createFromFormat('Y-m-d', $expiryDate),
            ]);
        }

        Auth::user()->employees()->save($employee);
        

        return redirect()->route('dashboard.employees.index')->with('success', 'Complimenti! Hai aggiunto un nuovo Dipendente');
    } catch (\Exception $e) {
        dd($e->getMessage());
    }
    }
    
    public function show($id)
    {
        $employee = Employee::with('documentEmployees')->findOrFail($id);
        return view('dashboard.employees.show', compact('employee'));
    }
    
    public function edit(Employee $employee)
    {

        
        $documentTypes = [
            'Ufficio' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica',],
            'Operaio' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica',],
            'Canalista' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica', 'Patente', 'Patente Carrelli', 'Patente PLE' , 'Lavori in quota'],
            'Frigorista' => ['Formazione Generale', 'Formazione Specifica', 'Visita Medica', 'Patente', 'Patente Carrelli', 'Patente PLE' ,],
        ];
        
        return view('dashboard.employees.edit', compact('employee', 'documentTypes'));
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
        'documentEmployees.*.pdf' => 'nullable|mimes:pdf|max:2048',
        'documentEmployees.*.expiry_date' => 'nullable|date',
    ]);

    $employeeData = [
        'name' => $request->input('name'),
        'surname' => $request->input('surname'),
        'fiscal_code' => $request->input('fiscal_code'),
        'birthday' => $request->input('birthday'),
        'phone' => $request->input('phone'),
        'address' => $request->input('address'),
        'email' => $request->input('email'),
        'email_work' => $request->input('email_work'),
        'role' => $request->input('role'),
    ];

    $employee->update($employeeData);

    $documentEmployees = $request->input('documents');

    if ($documentEmployees) {
        foreach ($documentEmployees as $key => $documentData) {
            $defaultName = $documentData['name'];
            $expiryDate = $documentData['expiry_date'];

            $document = $employee->documentEmployees()->where('name', $defaultName)->first();

            if ($document) {
                $pdf = $request->file("documentEmployees.$key.pdf");
                $pdfPath = $pdf ? $pdf->storeAs('pdf_documentEmployees', $defaultName . '.pdf', 'public') : $document->pdf_path;

                $document->update([
                    'pdf_path' => $pdfPath,
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
            
    }