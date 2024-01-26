<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MachinesSold;
use App\Models\WarrantyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MachineController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sortBy', 'default');
        $direction = $request->input('direction', 'asc');

        $columnTitles = [
            ['text' => 'Modello', 'sortBy' => 'model'],
            ['text' => 'Marca', 'sortBy' => 'brand'],
            ['text' => 'Propietario Attuale', 'sortBy' => 'buyer'],
            ['text' => 'Tipo Garanzia', 'sortBy' => 'warrantyType'],
            ['text' => 'Data installazione', 'sortBy' => 'sale_date'],
            'Modifica',
            'Elimina'
        ];
        $searchTerm = $request->input('machinesSearch');
        
        $screenWidth = $request->input('screenWidth');

        $routeName = 'dashboard.machinesSolds.index';
    
        
    
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

        $queryBuilder->when($sortBy == 'model', function ($query) use ($direction) {
            $query->orderBy('machines_solds.model', $direction);
        })->when($sortBy == 'brand', function ($query) use ($direction) {
            $query->orderBy('machines_solds.brand', $direction);
        })->when($sortBy == 'buyer', function ($query) use ($direction) {
            $query->orderBy('machines_solds.buyer', $direction);
        })->when($sortBy == 'warrantyType', function ($query) use ($direction) {
            $query->join('warranty_types', 'machines_solds.warranty_type_id', '=', 'warranty_types.id')
                  ->orderBy('warranty_types.name', $direction);
        })->when($sortBy == 'sale_date', function ($query) use ($direction) {
            $query->orderBy('machines_solds.sale_date', $direction);
        });

        $itemsPerPage = $screenWidth >= 1600 ? 50 : ($screenWidth >= 768 ? 18 : 18);
        $machines = $queryBuilder->paginate($itemsPerPage)->appends([
            'sortBy' => $sortBy,
            'direction' => $direction,
            'machinesSearch' => $searchTerm,
        ]);
    
        return view('dashboard.machinesSold.index', [
            'machines' => $machines,
            'sortBy' => $sortBy,
            'direction' => $direction,
            'routeName' => $routeName,
            'columnTitles' => $columnTitles,
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
        $machine = MachinesSold::create([
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

        Auth::user()->machinesSolds()->save($machine);
    
        return redirect()->route("dashboard.machinesSolds.index")->with("success", "Macchina inserita con successo.");
    }
    
    public function show(MachinesSold $machine)
    {
        return view("dashboard.machinesSold.show", compact('machine'));
    }
    
    public function edit(MachinesSold $machine)
    {
        // Implementa la logica per ottenere le opzioni da ARCA e dalle impostazioni
        $customers = DB::connection('mssql')->table('cf')->get();
        $brands = DB::connection('mssql')->table('ARMarca')->get();
        // Invia le Garanzie alla vista di modifica macchine
        $warranty_type = WarrantyType::all();

        // e passale alla vista di modifica.
        return view('dashboard.machinesSold.edit', compact('machine', 'warranty_type', 'brands', 'customers'));
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

        $lastModifiedUser = Auth::user();
        $machine->updated_by = $lastModifiedUser->name;

        $machine->save();
    
        return redirect()->route("dashboard.machinesSolds.index")->with("success", "Macchina aggiornata con successo.");
    }
    
    
    
    public function destroy(MachinesSold $machine)
    {
        $machine->delete();
        return redirect()->route('dashboard.machinesSolds.index')->with('success', 'Macchina eliminata con successo!');
    }
}
