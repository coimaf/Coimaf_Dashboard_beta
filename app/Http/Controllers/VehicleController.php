<?php

namespace App\Http\Controllers;

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
    public function index(Request $request)
    {

        $columnTitles = [
            'Tipo',
            'Marca',
            'Modello',
            'Targa',
            'Telaio',
            'Anno immatricolazione',
            'Modifica',
            'Elimina'
        ];
    
        $vehicles = Vehicle::all();
     
        return view('dashboard.vehicles.index', [
            'vehicles' => $vehicles,
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
                $path = $file->store('documenti');
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
public function update(Request $request, Vehicle $vehicle)
{
    $vehicle->update($request->all());

    $vehicle->TypeVehicle()->associate($request->input('type_vehicle_id'));

    $vehicle->updated_by_id = Auth::user()->id;
    
    $vehicle->save();
    
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
