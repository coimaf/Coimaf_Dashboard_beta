<?php

namespace App\Http\Controllers;

use App\Models\MachinesSold;
use App\Models\WarrantyType;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index()
    {
        $machines = MachinesSold::all();
        $columnTitles = [
            'Modello',
            'Marca',
            'Propietario Attuale',
            'Tipo Garanzia',
            'Scadenza Garanzia',
            'Modifica',
            'Elimina'
        ];
        return view('Dashboard.machinesSold.index', [
            'machines' => $machines,
            'columnTitles' => $columnTitles
        ]);
    }
    
    public function create()
    {
        // Implementa la logica per ottenere le opzioni da ARCA e dalle impostazioni

        // Invia le Garanzie alla vista di creazione macchine
        $warranty_type = WarrantyType::all();
        // e passale alla vista di creazione.
        return view('Dashboard.machinesSold.create', compact('warranty_type'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'model' => 'required',
            'brand' => 'required',
            'serial_number' => 'required',
            'sale_date' => 'required|date',
            'first_buyer' => 'required',
            'current_owner' => 'required',
            'warranty_expiration_date' => 'required|date',
            'warranty_type_id' => 'nullable|exists:warranty_types,id',
            'registration_date' => 'required|date',
            'delivery_ddt' => 'required',
            'notes' => 'required',
        ]);

        MachinesSold::create($request->all());

        return redirect()->route("dashboard.machinesSolds.index")->with("success", "Macchina inserita con successo.");
    }
    
    public function show(MachinesSold $machine)
    {
        return view("Dashboard.MachinesSold.show", compact('machine'));
    }
    
    public function edit(MachinesSold $machine)
    {
        // Implementa la logica per ottenere le opzioni da ARCA e dalle impostazioni
        // e passale alla vista di modifica.
        return view('machines.edit', compact('machine'));
    }
    
    public function update(Request $request, MachinesSold $machine)
    {
        // Implementa la logica per aggiornare i dati nel database.
    }
    
    public function destroy(MachinesSold $machine)
    {
        $machine->delete();
        return redirect()->route('dashboard.machinesSolds.index')->with('success', 'Macchina eliminata con successo!');
    }
}
