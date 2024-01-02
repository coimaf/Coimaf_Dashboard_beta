<?php

namespace App\Http\Controllers;

use App\Models\Deadline;
use App\Models\Employee;
use App\Models\MachinesSold;
use App\Models\WarrantyType;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
{
    $employees = Employee::search($request->searched)->get();
    $deadlines = Deadline::search($request->searched)->get();
    $machines = MachinesSold::search($request->searched)->get();
    $warrantyType = WarrantyType::search($request->searched)->get();
    $columnTitlesEmployees = ["Nome", "Codice Fiscale", "Ruolo", "Documenti", "Modifica", "Elimina"];
    $columnTitlesDeadlines = ["Nome Documento", "Scadenza", "Tag", "Modifica", "Elimina"];
    $columnTitlesMachines = [ 'Modello', 'Marca', 'Propietario Attuale', 'Tipo Garanzia', 'Scadenza Garanzia', 'Modifica', 'Elimina' ];

    return view('dashboard.search', compact('employees', 'deadlines', 'machines', 'warrantyType', 'columnTitlesEmployees', 'columnTitlesDeadlines', 'columnTitlesMachines'));
}

}
