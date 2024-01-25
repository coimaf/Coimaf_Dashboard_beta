<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MachinesSold;
use App\Models\WarrantyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MachineController extends Controller
{
    public function index(Request $request)
    {
        $columnTitles = [
            'Modello',
            'Marca',
            'Propietario Attuale',
            'Tipo Garanzia',
            'Scadenza Garanzia',
            'Modifica',
            'Elimina'
        ];
        $searchTerm = $request->input('machinesSearch');
    
        $queryBuilder = MachinesSold::with('warrantyType');
    
        if ($searchTerm) {
            $queryBuilder->where('machines_solds.model', 'like', '%' . $searchTerm . '%')
                ->orWhere('brand', 'LIKE', "%$searchTerm%")
                ->orWhere('serial_number', 'LIKE', "%$searchTerm%")
                ->orWhere('sale_date', 'LIKE', "%$searchTerm%")
                ->orWhere('old_buyer', 'LIKE', "%$searchTerm%")
                ->orWhere('buyer', 'LIKE', "%$searchTerm%")
                ->orWhere('warranty_expiration_date', 'LIKE', "%$searchTerm%")
                ->orWhere('registration_date', 'LIKE', "%$searchTerm%")
                ->orWhere('delivery_ddt', 'LIKE', "%$searchTerm%")
                ->orWhere('notes', 'LIKE', "%$searchTerm%")
                ->orWhereHas('warrantyType', function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', "%$searchTerm%");
                });
        }
    
        $machines = $queryBuilder->paginate(19);

        $machines->appends(['machinesSearch' => $searchTerm]);
    
        return view('dashboard.machinesSold.index', [
            'machines' => $machines,
            'columnTitles' => $columnTitles
        ]);
    }
    
    
    public function create()
    {
        $customers = DB::connection('mssql')->table('cf')->get();
        $brands = DB::connection('mssql')->table('ARMarca')->get();
        $warranty_type = WarrantyType::all();
        return view('dashboard.machinesSold.create', compact('warranty_type', 'customers', 'brands'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'model' => 'required',
            'brand' => 'required',
            'serial_number' => 'required',
            'warranty_type_id' => 'nullable|exists:warranty_types,id',
        ]);

        $currentDate = Carbon::now();
        $warranty_expiration_date = $currentDate->addYear();

        $registration_date = Carbon::today();
    
        // Aggiorna il nome del campo nel create
        MachinesSold::create([
            'model' => $request->input('model'),
            'brand' => $request->input('brand'),
            'serial_number' => $request->input('serial_number'),
            'sale_date' => $request->input('sale_date'),
            'warranty_expiration_date' => $warranty_expiration_date,
            'warranty_type_id' => $request->input('warranty_type_id'),
            'registration_date' => $registration_date,
            'delivery_ddt' => $request->input('delivery_ddt'),
            'old_buyer' => $request->input('old_buyer'),
            'buyer' => $request->input('buyer'),
            'notes' => $request->input('notes'),
        ]);

    
        return redirect()->route("dashboard.machinesSolds.index")->with("success", "Macchina inserita con successo.");
    }
    
    public function show(MachinesSold $machine)
    {
        return view("dashboard.MachinesSold.show", compact('machine'));
    }
    
    public function edit(MachinesSold $machine)
    {
        // Implementa la logica per ottenere le opzioni da ARCA e dalle impostazioni
        $customers = DB::connection('mssql')->table('cf')->get();
        $brands = DB::connection('mssql')->table('ARMarca')->get();
        // Invia le Garanzie alla vista di modifica macchine
        $warranty_type = WarrantyType::all();

        // e passale alla vista di modifica.
        return view('dashboard.MachinesSold.edit', compact('machine', 'warranty_type', 'brands', 'customers'));
    }
    
    public function update(Request $request, MachinesSold $machine)
    {
        $request->validate([
            'model' => 'required',
            'brand' => 'required',
            'serial_number' => 'required',
        ]);
    
        $machine->update($request->all());
    
        // Aggiorna i campi dei proprietari
        $machine->old_buyer = $request->input('old_buyer');
        $machine->buyer = $request->input('buyer');
        $machine->save();
    
        // Aggiorna la relazione Eloquent con il tipo di garanzia
        $machine->warrantyType()->associate($request->input('warranty_type_id'));
        $machine->save();
    
        return redirect()->route("dashboard.machinesSolds.index")->with("success", "Macchina aggiornata con successo.");
    }
    
    
    
    public function destroy(MachinesSold $machine)
    {
        $machine->delete();
        return redirect()->route('dashboard.machinesSolds.index')->with('success', 'Macchina eliminata con successo!');
    }
}
