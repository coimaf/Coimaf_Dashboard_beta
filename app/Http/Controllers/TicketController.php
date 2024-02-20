<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Technician;
use App\Models\Replacement;
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
        
        // Filtraggio per stato se specificato nella richiesta
        if ($request->has('status')) {
            $status = $request->input('status');
            $queryBuilder->where('status', $status);
        }
        
        // Filtraggio per ticket in attesa di ricambio
        if ($request->has('waiting_for_spare_parts')) {
            $queryBuilder->where('status', 'In attesa di un ricambio');
        }
        
        // Filtraggio per ticket urgenti
        if ($request->has('urgent')) {
            $queryBuilder->where('priority', 'Urgente');
        }
        
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
        $customers = DB::connection('mssql')
        ->table('cf')
        ->where('Cliente', 1)
        ->where('Obsoleto', 0)
        ->get();  
        
        // Crea una collezione fittizia di clienti
        // $customers = new Collection([
            //     (object) ['id' => 1, 'Descrizione' => 'Cliente A', 'Cd_CF' => 'clienteA@example.com'],
            //     (object) ['id' => 2, 'Descrizione' => 'Cliente B', 'Cd_CF' => 'clienteB@example.com'],
            // ]);
            
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
            $replacements = Replacement::where('ticket_id', $ticket->id)->get();
            return view("dashboard.tickets.show", compact('ticket', 'replacements'));
        }
        
        
        public function edit(Ticket $ticket, Request $request)
        {
            $machines = MachinesSold::all();
            $technicians = Technician::all();
            $customers = DB::connection('mssql')->table('cf')->get();
            $replacements = Replacement::where('ticket_id', $ticket->id)->get();
            
            $id_LSRevisione = DB::connection('mssql')
            ->table('LSRevisione')
            ->whereNotNull('DataPubblicazione')
            ->where('DataPubblicazione', '>', '1990-01-01')
            ->where('cd_ls', 'LSA0001')
            ->value('Id_LSRevisione');
            
            // dd($id_LSRevisione);
            
            $articles = DB::connection('mssql')
            ->table('AR')
            ->join('LSArticolo', 'AR.Cd_AR', '=', 'LSArticolo.Cd_AR')
            ->where('AR.Obsoleto', 0)
            ->where('LSArticolo.Id_LSRevisione', $id_LSRevisione)
            ->select('AR.Descrizione', 'AR.Cd_AR', 'LSArticolo.Prezzo')
            ->get();
            
            
            
            return view('dashboard.tickets.edit', compact('ticket', 'replacements', 'machines', 'technicians', 'customers', 'articles'));
        }
        
        public function update(Request $request, $id)
        {
            
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
            
            // Verifica se esistono sostituzioni associate a questo ticket
            $existingReplacements = Replacement::where('ticket_id', $ticket->id)->get();
            
            if ($existingReplacements->isEmpty()) {
                // Se non ci sono sostituzioni esistenti, crea una nuova istanza di Replacement
                $replacement = new Replacement();
            } else {
                // Se ci sono sostituzioni esistenti, prendi la prima riga (presumendo che ce ne sia solo una)
                $replacement = $existingReplacements->first();
            }
            
            // Aggiorna i campi di Replacement solo se i valori non sono vuoti
            if ($request->filled(['art', 'desc', 'qnt', 'prz', 'tot', 'sconto'])) {
                $replacement->ticket_id = $ticket->id;
                $replacement->art = $request->input('art');
                $replacement->desc = $request->input('desc');
                $replacement->qnt = $request->input('qnt');
                $replacement->prz = str_replace(',', '.', $request->input('prz')); // Converte il prezzo nel formato corretto
                $replacement->sconto = $request->input('sconto');
                $replacement->tot = str_replace(',', '.', $request->input('tot')); // Converte il totale nel formato corretto
                $replacement->save();
            }
            
            $daFatturare = Ticket::where('status', 'Da fatturare')->get();
            
            // dd($daFatturare);
            
            return redirect()->route('dashboard.tickets.edit', compact('ticket'))->with('success', 'Ticket aggiornato con successo!');
        }
        
        public function destroyReplacement($id)
        {
            $replacement = Replacement::findOrFail($id);
            $replacement->delete();
            
            return redirect()->back()->with('success', 'Ricambio eliminato con successo');
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
    