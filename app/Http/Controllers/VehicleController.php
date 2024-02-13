<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\TypeVehicle;
use Illuminate\Http\Request;
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
        
        return view('dashboard.vehicles.create', compact('typeVehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vehicle = Vehicle::create($request->all());

        $vehicle->TypeVehicle()->associate($request->input('type_vehicle_id'));

        $vehicle->user()->associate(Auth::user());
    
        $vehicle->save();
    
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
