<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vehicle;
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
            'Tipo',
            'Marca',
            'Modello',
            'Targa',
            'Telaio',
            'Anno immatricolazione',
            'Scadenza Documenti',
            'Modifica',
            'Elimina'
        ];
        
        $vehicles = Vehicle::all();
        $documentsDate = DocumentVehicles::where('vehicle_id', $vehicle->id)->get();
        $documents = DocumentVehicles::all();
        
        return view('dashboard.vehicles.index', [
            'vehicles' => $vehicles,
            'documentsDate' => $documentsDate,
            'documents' => $documents,
            'columnTitles' => $columnTitles,
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
        foreach ($request->documents as $documentId => $files) {
            foreach ($files as $file) {
                // Verifica se è stato caricato un file per il documento corrente
                if ($file->isValid()) {
                    $path = $file->store('pdfs', 'public');
                } else {
                    $path = null;
                }
                
                // Crea un nuovo documento veicolo e assegna le informazioni
                $documentVehicle = new DocumentVehicles();
                $documentVehicle->document_id = $documentId;
                $documentVehicle->vehicle_id = $vehicle->id;
                $documentVehicle->path = $path;
                $documentVehicle->expiry_date = $request->input("expiry_dates.{$documentId}");
                $documentVehicle->save();
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
        return view("dashboard.vehicles.show", compact('vehicle', 'documents','documentsDate', 'documentData'));
    }
    
    /**
    * Show the form for editing the specified resource.
    */
    public function edit(Vehicle $vehicle)
    {
        $typeVehicles = TypeVehicle::all();
        $documents = DocumentVehicle::all();
        $documentsDate = DocumentVehicles::where('vehicle_id', $vehicle->id)->get();
        
        
        return view("dashboard.vehicles.edit", compact('typeVehicles', 'vehicle', 'documents', 'documentsDate'));
    }
    
    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, Vehicle $vehicle)
    {
        $vehicle->update($request->all());
        
        $vehicle->TypeVehicle()->associate($request->input('type_vehicle_id'));
        
        $vehicle->updated_by_id = Auth::user()->id;
        
        $vehicle->save();
        
        // Verifica se ci sono documenti nella richiesta
        if ($request->has('documents')) {
            // Itera sui documenti nella richiesta
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
    
    private function getDocumentData($documents, $documentsDate)
    {
        $documentData = [];

        foreach ($documents as $document) {
            $expiryDate = Carbon::parse($documentsDate->firstWhere('document_id', $document->id)->expiry_date);
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
                'download_path' => asset("storage/{$documentsDate->firstWhere('document_id', $document->id)->path}"),
                'download_name' => $document->name,
            ];
        }

        return $documentData;
    }
}
