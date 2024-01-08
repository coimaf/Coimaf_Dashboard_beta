<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Technician;
use App\Models\MachinesSold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        return view('dashboard.tickets.index', [
            'tickets' => $tickets,
            'columnTitles' => $columnTitles
        ]);
    }
    
    public function create()
    {
        $machines = MachinesSold::all();
        $technicians = Technician::all();
        $nextTicketNumber = DB::table('tickets')->max('id') + 1;
        return view('dashboard.tickets.create', compact('machines', 'nextTicketNumber', 'technicians'));
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
            'status' => $request->input('status'),
            'priority' => $request->input('priority'),
        ]);
        
        // Salva il ticket nel database
        $ticket->save();
        
        // Associa il tecnico al ticket
        $ticket->technician()->associate($request->input('technician_id'));
        $ticket->save();
        
        return redirect()->route('dashboard.tickets.index')->with('success', 'Ticket creato con successo!');
    }

    public function show(Ticket $ticket)
    {
        return view("dashboard.Tickets.show", compact('ticket'));
    }
    
    
    public function edit(Ticket $ticket)
    {
        
        $machines = MachinesSold::all();
        $technicians = Technician::all();

        return view('dashboard.tickets.edit', compact('ticket', 'machines', 'technicians'));
    }
    
    public function update(Request $request, Ticket $ticket)
    {
        // Aggiorna i dati del ticket
        $ticket->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'notes' => $request->input('notes'),
            'machine_model_id' => $request->input('machine_model_id'),
            'machine_sold_id' => $request->input('machine_sold_id'),
            'closed' => $request->input('closed'),
            'status' => $request->input('status'),
            'priority' => $request->input('priority'),
        ]);
        
        // Associa il tecnico al ticket
        $ticket->technician()->associate($request->input('technician_id'));
        $ticket->save();
        
        return redirect()->route('dashboard.tickets.index')->with('success', 'Ticket aggiornato con successo!');
    }
    
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        
        return redirect()->route('dashboard.tickets.index')->with('success', 'Ticket eliminato con successo!');
    }
    
}
