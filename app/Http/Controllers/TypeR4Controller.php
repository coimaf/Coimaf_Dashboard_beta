<?php

namespace App\Http\Controllers;

use App\Models\TypeR4;
use Illuminate\Http\Request;

class TypeR4Controller extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typeR4 = TypeR4::all();
        return view('dashboard.settings.r4.create', compact('typeR4'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $typeR4 = TypeR4::create(['name' => $request->name]);

        return redirect()->route('dashboard.settings.r4.create')->with('success', 'Tipo aggiunto con successo!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($typeR4Id)
    {
        $r4 = TypeR4::find($typeR4Id);
        $r4->delete();

        return redirect()->route('dashboard.settings.r4.create')->with('success', 'Tipo rimosso con successo!');
    }
}
