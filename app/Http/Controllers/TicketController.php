<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\MachinesSold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        $columnTitles = [
            'Ticket ID',
            'Titolo',
            'Stato',
            'Priorità',
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
        $nextTicketNumber = DB::table('tickets')->max('id') + 1;
        return view('Dashboard.tickets.create', compact('machines', 'nextTicketNumber'));
    }

    public function store(Request $request)
    {

        Ticket::create($request->all());

        return redirect()->route('dashboard.tickets.index')->with('success', 'Ticket creato con successo!');
    }
}
