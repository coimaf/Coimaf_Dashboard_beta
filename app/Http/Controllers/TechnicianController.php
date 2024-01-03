<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $technicians = Technician::all();
        return view('dashboard.settings.technicians.create', compact('technicians'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'surname' => ['required']
            ]);
            Technician::create($validatedData);
            return redirect()->route('dashboard.settings.tecnicians.create')->with('success','Tecnico aggiunto con successo!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technician $technician)
    {
        $technician->delete();
        return redirect()->route('dashboard.settings.tecnicians.create')->with('success', 'Tecnico eliminato con successo!');
    }
}
