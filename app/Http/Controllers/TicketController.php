<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Technician;
use App\Models\MachinesSold;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewTicketNotification;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sortBy', 'default');
        $direction = $request->input('direction', 'asc');
        $tickets = Ticket::with('technician')->get();
        $columnTitles = [
            ['text' => 'Ticket ID', 'sortBy' => 'id'],
            ['text' => 'Titolo', 'sortBy' => 'title'],
            ['text' => 'Stato', 'sortBy' => 'status'],
            ['text' => 'Priorità', 'sortBy' => 'priority'],
            ['text' => 'Tecnico', 'sortBy' => 'technician'],
            'Modifica',
            'Elimina'
        ];
    
        $searchTerm = $request->input('ticketsSearch');

        $routeName = 'dashboard.tickets.index';
    
        $queryBuilder = Ticket::with(['machinesSold', 'machineModel', 'technician']);
    
        if ($searchTerm) {
            $queryBuilder->where('tickets.title', 'like', '%' . $searchTerm . '%')
                ->orWhere('description', 'LIKE', "%$searchTerm%")
                ->orWhere('closed', 'LIKE', "%$searchTerm%")
                ->orWhere('notes', 'LIKE', "%$searchTerm%")
                ->orWhere('descrizione', 'LIKE', "%$searchTerm%")
                ->orWhere('cd_cf', 'LIKE', "%$searchTerm%")
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
                });
        }

        $queryBuilder->when($sortBy == 'id', function ($query) use ($direction) {
            $query->orderBy('tickets.id', $direction);
        })->when($sortBy == 'title', function ($query) use ($direction) {
            $query->orderBy('tickets.title', $direction);
        })->when($sortBy == 'status', function ($query) use ($direction) {
            $query->orderBy('tickets.status', $direction);
        })
        ->when($sortBy == 'priority', function ($query) use ($direction) {
            $query->orderBy('tickets.priority', $direction);
        })->when($sortBy == 'technician', function ($query) use ($direction) {
            $query->join('technicians', 'tickets.technician_id', '=', 'technicians.id')
                  ->orderBy('technicians.name', $direction);
        });
    
        $tickets = $queryBuilder->paginate(25)->appends([
            'sortBy' => $sortBy,
            'direction' => $direction,
            'ticketsSearch' => $searchTerm,
        ]);
    
        return view('dashboard.tickets.index', [
            'tickets' => $tickets,
            'sortBy' => $sortBy,
            'direction' => $direction,
            'routeName' => $routeName,
            'columnTitles' => $columnTitles,
        ]);
    }
    
    
    public function create()
    {
        $machines = MachinesSold::all();
        $technicians = Technician::all();
        $nextTicketNumber = DB::table('tickets')->max('id') + 1;
        // $customers = DB::connection('mssql')
        // ->table('cf')
        // ->where('Cliente', 1)
        // ->where('Obsoleto', 0)
        // ->get();  
        
        // Crea una collezione fittizia di clienti
        $customers = new Collection([
            (object) ['id' => 1, 'Descrizione' => 'Cliente A', 'Cd_CF' => 'clienteA@example.com'],
            (object) ['id' => 2, 'Descrizione' => 'Cliente B', 'Cd_CF' => 'clienteB@example.com'],
            // Aggiungi altri clienti come desiderato
        ]);

        return view('dashboard.tickets.create', compact('machines', 'nextTicketNumber', 'technicians', 'customers'));
    }
    
    public function store(Request $request)
{
    // Validazione dei dati
    $request->validate([
        'selectedCustomer' => 'required',
        'selectedCdCF' => 'required',
    ]);

    // Continua con il tuo codice
    $ticket = new Ticket([
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'intervention_date' => $request->input('intervention_date'),
        'notes' => $request->input('notes'),
        'machine_model_id' => $request->input('machine_model_id'),
        'machine_sold_id' => $request->input('machine_sold_id'),
        'closed' => $request->input('closed'),
        'status' => $request->input('status'),
        'priority' => $request->input('priority'),
        'descrizione' => trim($request->input('selectedCustomer')),
        'cd_cf' => $request->input('selectedCdCF'),
    ]);

    // Salva il ticket nel database
    $ticket->save();

    // Associa il tecnico al ticket
    $ticket->technician()->associate($request->input('technician_id'));
    $ticket->save();
    
    $ticket->user()->associate(Auth::user());
    
    $ticket->save();

    // Invia la notifica passando l'oggetto del ticket
    \Illuminate\Support\Facades\Notification::route('mail', 'nicola.mazzaferro@coimaf.com')
    ->notify(new NewTicketNotification($ticket));

    return redirect()->route('dashboard.tickets.index')->with('success', 'Ticket creato con successo!');
}

    

    public function show(Ticket $ticket)
    {
        return view("dashboard.tickets.show", compact('ticket'));
    }
    
    
    public function edit(Ticket $ticket)
    {
        
        $machines = MachinesSold::all();
        $technicians = Technician::all();
        $customers = DB::connection('mssql')->table('cf')->get();

        return view('dashboard.tickets.edit', compact('ticket', 'machines', 'technicians', 'customers'));
    }
    
    public function update(Request $request, $id)
    {
        // Validazione dei dati
        // $request->validate([
        //     'selectedCustomer' => 'required',
        //     'selectedCdCF' => 'required',
        // ]);
    
        // Trova il ticket da aggiornare
        $ticket = Ticket::findOrFail($id);
    
        // Aggiorna i campi del ticket con i nuovi valori
        $ticket->title = $request->input('title');
        $ticket->description = $request->input('description');
        $ticket->notes = $request->input('notes');
        $ticket->machine_model_id = $request->input('machine_model_id');
        $ticket->machine_sold_id = $request->input('machine_sold_id');
        $ticket->closed = $request->input('closed');
        $ticket->status = $request->input('status');
        $ticket->priority = $request->input('priority');
        $ticket->descrizione = trim($request->input('selectedCustomer'));
        $ticket->cd_cf = $request->input('selectedCdCF');
    
        // Aggiorna l'associazione del tecnico al ticket
        $ticket->technician()->associate($request->input('technician_id'));
    
        $ticket->updated_by = Auth::user()->id;
    
        $ticket->save();
    
        return redirect()->route('dashboard.tickets.index')->with('success', 'Ticket aggiornato con successo!');
    }
    

    
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        
        return redirect()->route('dashboard.tickets.index')->with('success', 'Ticket eliminato con successo!');
    }

    public function print(Ticket $ticket) {
        $ticketCdCf = $ticket->cd_cf;
    
        $indirizziStampati = [];
        $indirizziFiltrati = [];
    
        $customers = DB::connection('mssql')
            ->table('cfcontatto')
            ->where('cd_cf', $ticketCdCf)
            ->get();  
        $infoCustomers = DB::connection('mssql')
            ->table('cf4mm')
            ->where('cd_cf', $ticketCdCf)
            ->get();
        
        foreach ($infoCustomers as $info) {
            if (!in_array($info->Indirizzo, $indirizziStampati)) {
                $indirizziFiltrati[] = $info->Indirizzo;
                $indirizziStampati[] = $info->Indirizzo;
            }
        }
        $indirizziFiltrati = array_unique($indirizziFiltrati);
    
        return view('components.printTicket', compact('ticket', 'customers', 'infoCustomers', 'indirizziFiltrati'));
    }
    
    
}
