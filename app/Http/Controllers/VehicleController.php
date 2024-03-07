<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vehicle;
use App\Models\Maintenance;
use App\Models\TypeVehicle;
use Illuminate\Http\Request;
use App\Models\DocumentVehicle;
use App\Models\VehicleDocument;
use App\Models\DocumentVehicles;
use App\Models\VehicleMaintenance;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index(Request $request, Vehicle $vehicle)
    {
        
        $columnTitles = [
            ['text' => 'Tipo', 'sortBy' => 'TypeVehicle'],
            ['text' => 'Marca', 'sortBy' => 'brand'],
            ['text' => 'Modello', 'sortBy' => 'model'],
            ['text' => 'Targa', 'sortBy' => 'license_plate'],
            ['text' => 'Telaio', 'sortBy' => 'chassis'],
            'Anno immatricolazione',
            'Scadenza Documenti',
            'Modifica',
            'Elimina'
        ];
        
        $vehicles = Vehicle::all();
        
        $queryBuilder = Vehicle::with(['TypeVehicle']);
        $searchTerm = $request->input('vehicleSearch');
        
        $sortBy = $request->input('sortBy', 'default');
        $direction = $request->input('direction', 'asc');
        $routeName = 'dashboard.vehicles.index';

        if ($request->has('inscadenza')) {
            $queryBuilder->whereHas('documents', function ($query) {
                $query->where('expiry_date', '>', now())
                    ->where('expiry_date', '<=', now()->addDays(60));
            });
        }
        
        // Aggiungi la condizione per le scadenze scadute
        if ($request->has('scaduti')) {
            $queryBuilder->whereHas('documents', function ($query) {
                $query->where('expiry_date', '<', now());
            });
        }
        
        if ($searchTerm) {
            $queryBuilder->where('brand', 'like', '%' . $searchTerm . '%')
            ->orWhere('model', 'LIKE', "%$searchTerm%")
            ->orWhere('license_plate', 'LIKE', "%$searchTerm%")
            ->orWhere('chassis', 'LIKE', "%$searchTerm%")
            ->orWhere('registration_year', 'LIKE', "%$searchTerm%")
            ->orWhereHas('TypeVehicle', function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%$searchTerm%");
            });
        }
        
        $queryBuilder->when($sortBy == 'brand', function ($query) use ($direction) {
            $query->orderBy('brand', $direction);
        })->when($sortBy == 'model', function ($query) use ($direction) {
            $query->orderBy('model', $direction);
        })->when($sortBy == 'license_plate', function ($query) use ($direction) {
            $query->orderBy('license_plate', $direction);
        })->when($sortBy == 'chassis', function ($query) use ($direction) {
            $query->orderBy('chassis', $direction);
        })->when($sortBy == 'TypeVehicle', function ($query) use ($direction) {
            $query->join('type_vehicles', 'type_vehicle_id', '=', 'type_vehicles.id')
            ->orderBy('type_vehicles.name', $direction);
        });
        
        $vehicles = $queryBuilder->paginate(25)->appends([
            'ticketsSearch' => $searchTerm,
        ]);
        
        return view('dashboard.vehicles.index', [
            'vehicles' => $vehicles,
            'columnTitles' => $columnTitles,
            'sortBy' => $sortBy,
            'direction' => $direction,
            'routeName' => $routeName,
        ]);
    }
    
    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        $typeVehicles = TypeVehicle::all();
        
        return view('dashboard.vehicles.create', compact('typeVehicles'));
    }
    
    /**
    * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        // Validazione dei campi del veicolo
        
        // Crea un nuovo veicolo
        $vehicle = Vehicle::create($request->all());
        
        // Associa il tipo di veicolo
        $vehicle->TypeVehicle()->associate($request->input('type_vehicle_id'));
        
        // Associa l'utente autenticato al veicolo
        $vehicle->user()->associate(Auth::user());
        
        // Salva il veicolo nel database
        $vehicle->save();
        
        // Se sono stati forniti documenti, li elabora
        if ($request->filled('document_name')) {
            foreach ($request->input('document_name') as $key => $documentName) {
                if (!empty($documentName)) {
                    $document = new VehicleDocument();
                    $document->name = $documentName;
                    if ($request->hasFile('document_file.' . $key)) {
                        $document->file = $request->file('document_file')[$key]->store('Flotta', 'public');
                    }
                    $document->date_start = $request->input('document_date_start.' . $key); // Campo data di inizio
                    $document->expiry_date = $request->input('document_expiry_date.' . $key); // Campo data di scadenza
                    $document->vehicle_id = $vehicle->id;
                    $document->save();
                }
            }            
        }
        
        return redirect()->route("dashboard.vehicles.index")->with("success", "Veicolo inserito con successo.");
    }
    
    
    /**
    * Display the specified resource.
    */
    public function show(Vehicle $vehicle)
    {
        return view("dashboard.vehicles.show", compact('vehicle'));
    }
    
    /**
    * Show the form for editing the specified resource.
    */
    public function edit(Vehicle $vehicle)
    {
        $typeVehicles = TypeVehicle::all();  
        
        return view("dashboard.vehicles.edit", compact('typeVehicles', 'vehicle'));
    }
    
    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, $id)
    {
        // Trova il veicolo da aggiornare
        $vehicle = Vehicle::findOrFail($id);
        
        // Aggiorna i campi del veicolo
        $vehicle->update($request->all());
        
        // Se sono stati forniti documenti, li elabora
        if ($request->filled('document_id')) {
            foreach ($request->input('document_id') as $key => $documentId) {
                // Trova il documento esistente
                $document = VehicleDocument::findOrFail($documentId);
                
                // Modifica solo se sono stati forniti nuovi dati
                if ($request->hasFile('document_file.' . $key)) {
                    $document->file = $request->file('document_file')[$key]->store('Flotta', 'public');
                }
                $document->name = $request->input('document_name.' . $key);
                $document->date_start = $request->input('document_date_start.' . $key);
                $document->expiry_date = $request->input('document_expiry_date.' . $key);
                $document->save();
            }
        }
        
        // Se sono stati forniti nuovi documenti, li salva
        if ($request->filled('new_document_name')) {
            foreach ($request->input('new_document_name') as $key => $documentName) {
                // Crea un nuovo documento
                $newDocument = new VehicleDocument();
                $newDocument->name = $documentName;
                $newDocument->date_start = $request->input('new_document_date_start.' . $key);
                $newDocument->expiry_date = $request->input('new_document_expiry_date.' . $key);
                
                // Se è fornito un file, lo salva
                if ($request->hasFile('new_document_file.' . $key)) {
                    $newDocument->file = $request->file('new_document_file')[$key]->store('Flotta', 'public');
                }
                
                // Associa il documento al veicolo
                $vehicle->documents()->save($newDocument);
            }
        }
        
        // Se sono state fornite nuove manutenzioni, le salva
        if ($request->filled('new_maintenance_name')) {
            foreach ($request->input('new_maintenance_name') as $key => $maintenanceName) {
                // Crea una nuova manutenzione
                $newMaintenance = new VehicleMaintenance();
                $newMaintenance->name = $maintenanceName;
                // Verifica se è stata fornita una descrizione per la manutenzione e imposta il valore se presente
                $newMaintenance->description = $request->input('new_maintenance_description.' . $key, null);
                // Verifica se è stato caricato un file per la manutenzione e imposta il valore se presente
                if ($request->hasFile('new_maintenance_file.' . $key)) {
                    $newMaintenance->file = $request->file('new_maintenance_file.' . $key)->store('Flotta', 'public');
                }
                // Verifica se è stato fornito un prezzo per la manutenzione e imposta il valore se presente
                $newMaintenance->price = $request->input('new_maintenance_price.' . $key, null);
                // Verifica se è stata fornita una data di esecuzione per la manutenzione e imposta il valore se presente
                $newMaintenance->start_at = $request->input('new_maintenance_start_at.' . $key, null);
                // Associa la manutenzione al veicolo
                $vehicle->maintenances()->save($newMaintenance);
            }
        }
        
        // Se sono state fornite modifiche per le manutenzioni esistenti, le aggiorna nel database
        if ($request->filled('maintenance_id')) {
            foreach ($request->input('maintenance_id') as $key => $maintenanceId) {
                // Trova la manutenzione esistente
                $existingMaintenance = VehicleMaintenance::findOrFail($maintenanceId);
                // Aggiorna i dettagli della manutenzione
                $existingMaintenance->update([
                    'name' => $request->input('maintenance_name.' . $key),
                    'description' => $request->input('maintenance_description.' . $key, null),
                    // Aggiorna il file solo se è stato fornito un nuovo file
                    'file' => $request->hasFile('maintenance_file.' . $key) ? $request->file('maintenance_file.' . $key)->store('Flotta', 'public') : $existingMaintenance->file,
                    'price' => $request->input('maintenance_price.' . $key, null),
                    'start_at' => $request->input('maintenance_start_at.' . $key, null),
                ]);
            }
        }
        
        return redirect()->route("dashboard.vehicles.index")->with("success", "Veicolo aggiornato con successo.");
    }
    
    
    /**
    * Remove the specified resource from storage.
    */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        
        return redirect()->route("dashboard.vehicles.index")->with("success", "Veicolo eliminato con successo.");
    }
    
}
