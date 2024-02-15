<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vehicle;
use App\Models\Maintenance;
use App\Models\TypeVehicle;
use Illuminate\Http\Request;
use App\Models\DocumentVehicle;
use App\Models\DocumentVehicles;
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
        $documentsDate = DocumentVehicles::where('vehicle_id', $vehicle->id)->get();
        $documents = DocumentVehicles::all();

        $queryBuilder = Vehicle::with(['documents', 'TypeVehicle']);
        $searchTerm = $request->input('vehicleSearch');

        $sortBy = $request->input('sortBy', 'default');
        $direction = $request->input('direction', 'asc');
        $routeName = 'dashboard.vehicles.index';

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

          
  // Filtraggio per documenti in scadenza
if ($request->has('inscadenza')) {
    // Recupera solo i veicoli che hanno documenti in scadenza
    $vehiclesWithExpiringDocuments = Vehicle::whereHas('documents', function ($query) {
        $query->where('expiry_date', '>', now())
              ->where('expiry_date', '<=', now()->addDays(60)); // Aggiungi il punto e virgola qui
    })->paginate(25)->appends(['inscadenza' => true]);

    // Restituisci la vista con i veicoli che hanno documenti in scadenza
    return view('dashboard.vehicles.index', [
        'vehicles' => $vehiclesWithExpiringDocuments,
        'columnTitles' => $columnTitles,
        'sortBy' => $sortBy,
        'direction' => $direction,
        'routeName' => $routeName,
    ]);
}

// Filtraggio per documenti scaduti
if ($request->has('scaduti')) {
    // Recupera solo i veicoli che hanno documenti scaduti
    $vehiclesWithExpiredDocuments = Vehicle::whereHas('documents', function ($query) {
        $query->where('expiry_date', '<', now());
    })->paginate(25)->appends(['scaduti' => true]);

    // Restituisci la vista con i veicoli che hanno documenti scaduti
    return view('dashboard.vehicles.index', [
        'vehicles' => $vehiclesWithExpiredDocuments,
        'columnTitles' => $columnTitles,
        'sortBy' => $sortBy,
        'direction' => $direction,
        'routeName' => $routeName,
    ]);
}



        return view('dashboard.vehicles.index', [
            'vehicles' => $vehicles,
            'documentsDate' => $documentsDate,
            'documents' => $documents,
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
        $documents = DocumentVehicle::all();
        
        return view('dashboard.vehicles.create', compact('typeVehicles', 'documents'));
    }
    
    /**
    * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        // Crea un nuovo veicolo
        $vehicle = Vehicle::create($request->all());
        
        // Associa il tipo di veicolo
        $vehicle->TypeVehicle()->associate($request->input('type_vehicle_id'));
        
        // Associa l'utente autenticato al veicolo
        $vehicle->user()->associate(Auth::user());
        
        // Salva il veicolo nel database
        $vehicle->save();
        
        // Itera sui documenti nella richiesta
        if ($request->has('documents')) {
            foreach ($request->documents as $documentId => $files) {
                foreach ($files as $file) {
                    // Verifica se è stato caricato un file per il documento corrente
                    if ($file->isValid()) {
                        $path = $file->store('pdfs', 'public');
        
                        // Crea un nuovo documento veicolo e assegna le informazioni
                        $documentVehicle = new DocumentVehicles();
                        $documentVehicle->document_id = $documentId;
                        $documentVehicle->vehicle_id = $vehicle->id;
                        $documentVehicle->path = $path;
                        $documentVehicle->expiry_date = $request->input("expiry_dates.{$documentId}");
                        $documentVehicle->save();
                    }
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
        $documents = DocumentVehicle::all();
        $documentsDate = DocumentVehicles::where('vehicle_id', $vehicle->id)->get();
        $documentData = $this->getDocumentData($documents, $documentsDate);
        $maintenance = $vehicle->maintenances;
        return view("dashboard.vehicles.show", compact('vehicle', 'documents','documentsDate', 'documentData', 'maintenance'));
    }
    
    /**
    * Show the form for editing the specified resource.
    */
    public function edit(Vehicle $vehicle)
    {
        $typeVehicles = TypeVehicle::all();
        $documents = DocumentVehicle::all();
        $documentsDate = DocumentVehicles::where('vehicle_id', $vehicle->id)->get();
        $maintenance = $vehicle->maintenances;
        
        
        return view("dashboard.vehicles.edit", compact('typeVehicles', 'vehicle', 'documents', 'documentsDate', 'maintenance'));
    }
    
    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, Vehicle $vehicle , Maintenance $maintenance)
    {
        $vehicle->update($request->all());
        
        $vehicle->TypeVehicle()->associate($request->input('type_vehicle_id'));
        
        $vehicle->updated_by_id = Auth::user()->id;
        
        $vehicle->save();
    
        // Aggiunta della nuova manutenzione solo se i campi non sono vuoti
        $maintenanceData = [
            'name' => $request->input('name'),
            'start_at' => $request->input('start_at'),
            'expiry_date' => $request->input('expiry_date'),
        ];
    
        // Verifica se i campi per la manutenzione sono vuoti
        if (!empty(array_filter($maintenanceData))) {
            // Crea la nuova manutenzione solo se i campi non sono vuoti
            $vehicle->maintenances()->create($maintenanceData);
        }
    
        // Itera sui documenti nella richiesta
        // Verifica se ci sono documenti nella richiesta
        if ($request->has('documents')) {
            foreach ($request->documents as $documentId => $files) {
                // Trova il documento veicolo corrente o crea un nuovo oggetto se non esiste
                $documentVehicle = DocumentVehicles::where('vehicle_id', $vehicle->id)
                    ->where('document_id', $documentId)
                    ->first();
                    
                // Verifica se $files è un array valido prima di iterare su di esso
                if (is_array($files)) {
                    foreach ($files as $file) {
                        // Verifica se è stato caricato un file per il documento corrente
                        if ($file->isValid()) {
                            $path = $file->store('pdfs', 'public');
                            
                            if ($documentVehicle) {
                                // Aggiorna il percorso del file solo se il file è stato caricato
                                $documentVehicle->path = $path;
                            }
                        }
                    }
                }
                
                // Aggiorna la data di scadenza anche se non è stato caricato un nuovo file
                if ($documentVehicle) {
                    $documentVehicle->expiry_date = $request->input("expiry_dates.{$documentId}");
                    $documentVehicle->save();
                }
            }
        }
        
        // Aggiorna la data di scadenza per i documenti anche se non sono stati inviati nuovi documenti
        foreach ($request->input('expiry_dates', []) as $documentId => $expiryDate) {
            $documentVehicle = DocumentVehicles::where('vehicle_id', $vehicle->id)
                ->where('document_id', $documentId)
                ->first();
                
            if ($documentVehicle) {
                $documentVehicle->expiry_date = $expiryDate;
                $documentVehicle->save();
            }
        }
            
        return redirect()->route("dashboard.vehicles.edit", compact('vehicle'))->with("success", "Veicolo aggiornato con successo.");
    }
    
    
    
    /**
    * Remove the specified resource from storage.
    */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        
        return redirect()->route("dashboard.vehicles.index")->with("success", "Veicolo eliminato con successo.");
    }
    
    private function getDocumentData($documents, $documentsDate)
    {
        $documentData = [];
    
        foreach ($documents as $document) {
            $documentInfo = $documentsDate->firstWhere('document_id', $document->id);
    
            // Verifica se esiste un record per il documento corrente
            if ($documentInfo) {
                $expiryDate = Carbon::parse($documentInfo->expiry_date);
                $today = Carbon::today();
                $daysUntilExpiry = $today->diffInDays($expiryDate, false);
    
                if ($daysUntilExpiry <= 0) {
                    $icon = 'bi bi-circle-fill text-danger'; // Rosso se scaduto
                } elseif ($daysUntilExpiry <= 60) {
                    $icon = 'bi bi-circle-fill text-warning'; // Giallo se meno di 30 giorni alla scadenza
                } else {
                    $icon = 'bi bi-circle-fill text-success'; // Verde se valido
                }
    
                $documentData[] = [
                    'name' => $document->name,
                    'expiry_date' => $expiryDate->format('d-m-Y'),
                    'icon' => $icon,
                    'download_path' => asset("storage/{$documentInfo->path}"),
                    'download_name' => $document->name,
                ];
            }
        }
    
        return $documentData;
    }
    
    public function destroyMaintenance(Vehicle $vehicle, Maintenance $maintenance)
{
    $maintenance->delete();
    return redirect()->back()->with('success', 'Manutenzione eliminata con successo.');
}

}
