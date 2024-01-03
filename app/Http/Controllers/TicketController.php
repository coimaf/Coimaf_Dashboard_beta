<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Technician;
use App\Models\MachinesSold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('technician')->get();
        $columnTitles = [
            'Ticket ID',
            'Titolo',
            'Stato',
            'Priorità',
            'Tecnico',
            'Modifica',
            'Elimina'
        ];
        return view('Dashboard.tickets.index', [
            'tickets' => $tickets,
            'columnTitles' => $columnTitles
        ]);
    }

    public function create()
    {
        $machines = MachinesSold::all();
        $technicians = Technician::all();
        $nextTicketNumber = DB::table('tickets')->max('id') + 1;
        return view('Dashboard.tickets.create', compact('machines', 'nextTicketNumber', 'technicians'));
    }

    public function store(Request $request)
    {
    
        $ticket = new Ticket([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'notes' => $request->input('notes'),
            'machine_model_id' => $request->input('machine_model_id'),
            'machine_sold_id' => $request->input('machine_sold_id'),
            'closed' => $request->input('closed'),
        ]);
    
        // Salva il ticket nel database
        $ticket->save();
    
        // Associa il tecnico al ticket
        $ticket->technician()->associate($request->input('technician_id'));
        $ticket->save();
    
    
        return redirect()->route('dashboard.tickets.index')->with('success', 'Ticket creato con successo!');
    }
    
}
