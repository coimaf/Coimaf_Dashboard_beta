<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Deadline;
use App\Models\Employee;
use App\Models\MachinesSold;
use App\Models\WarrantyType;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->searched;

        $employees = Employee::where('name', 'LIKE', "%$searchTerm%")
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
            })
            ->get();

        $deadlines = Deadline::where('name', 'LIKE', "%$searchTerm%")
            ->orWhere('description', 'LIKE', "%$searchTerm%")
            ->orWhereHas('tags', function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%$searchTerm%");
            })
            ->get();

        $machines = MachinesSold::where('model', 'LIKE', "%$searchTerm%")
            ->orWhere('brand', 'LIKE', "%$searchTerm%")
            ->orWhere('serial_number', 'LIKE', "%$searchTerm%")
            ->orWhere('sale_date', 'LIKE', "%$searchTerm%")
            ->orWhere('old_buyer', 'LIKE', "%$searchTerm%")
            ->orWhere('buyer', 'LIKE', "%$searchTerm%")
            ->orWhere('warranty_expiration_date', 'LIKE', "%$searchTerm%")
            ->orWhere('registration_date', 'LIKE', "%$searchTerm%")
            ->orWhere('delivery_ddt', 'LIKE', "%$searchTerm%")
            ->orWhere('notes', 'LIKE', "%$searchTerm%")
            ->orWhereHas('warrantyType', function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%$searchTerm%");
            })
            ->get();

        $tickets = Ticket::where('title', 'LIKE', "%$searchTerm%")
            ->orWhere('description', 'LIKE', "%$searchTerm%")
            ->orWhere('closed', 'LIKE', "%$searchTerm%")
            ->orWhere('notes', 'LIKE', "%$searchTerm%")
            ->orWhere('descrizione', 'LIKE', "%$searchTerm%")
            ->orWhere('cd_cf', 'LIKE', "%$searchTerm%")
            ->orWhere('machine_sold_id', 'LIKE', "%$searchTerm%")
            ->orWhere('machine_model_id', 'LIKE', "%$searchTerm%")
            ->orWhere('status', 'LIKE', "%$searchTerm%")
            ->orWhere('priority', 'LIKE', "%$searchTerm%")
            ->orWhereHas('technician', function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%$searchTerm%");
            })
            ->orWhereHas('technician', function ($query) use ($searchTerm) {
                $query->where('surname', 'LIKE', "%$searchTerm%");
            })
            ->orWhereHas('machinesSold', function ($query) use ($searchTerm) {
                $query->where('model', 'LIKE', "%$searchTerm%");
            })
            ->orWhereHas('machinesSold', function ($query) use ($searchTerm) {
                $query->where('serial_number', 'LIKE', "%$searchTerm%");
            })
            ->orWhereHas('machineModel', function ($query) use ($searchTerm) {
                $query->where('model', 'LIKE', "%$searchTerm%");
            })
            ->get();

        $columnTitlesEmployees = ["Nome", "Codice Fiscale", "Ruolo", "Documenti", "Modifica", "Elimina"];
        $columnTitlesDeadlines = ["Nome Documento", "Scadenza", "Tag", "Modifica", "Elimina"];
        $columnTitlesMachines = ['Modello', 'Marca', 'Propietario Attuale', 'Tipo Garanzia', 'Scadenza Garanzia', 'Modifica', 'Elimina'];
        $columnTitlesTickets = ['Ticket ID', 'Titolo', 'Stato', 'Priorità', 'Tecnico', 'Modifica', 'Elimina'];

        return view('dashboard.search', compact(
            'employees',
            'deadlines',
            'machines',
            'tickets',
            'columnTitlesEmployees',
            'columnTitlesDeadlines',
            'columnTitlesMachines',
            'columnTitlesTickets'
        ));
    }
}
