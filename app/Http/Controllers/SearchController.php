<?php

namespace App\Http\Controllers;

use App\Models\Deadline;
use App\Models\Employee;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
{
    $employees = Employee::search($request->searched)->get();
    $deadlines = Deadline::search($request->searched)->get();
    $columnTitlesEmployees = ["Nome", "Codice Fiscale", "Ruolo", "Documenti", "Modifica", "Elimina"];
    $columnTitlesDeadlines = ["Nome Documento", "Scadenza", "Tag", "Modifica", "Elimina"];

    return view('dashboard.search', compact('employees', 'deadlines', 'columnTitlesEmployees', 'columnTitlesDeadlines'));
}

}
