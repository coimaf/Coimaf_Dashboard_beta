<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Deadline;
use App\Models\Tag; // Assicurati di importare il modello Tag
use Illuminate\Http\Request;

class DeadlineController extends Controller
{
    public function index()
    {
        $columnTitles = ["Nome Documento", "Scadenza", "Tag", "Modifica", "Elimina"];
        $deadlines = Deadline::with('documentDeadlines')->get();
        
        return view('dashboard.deadlines.index', [
            'columnTitles' => $columnTitles,
            'deadlines' => $deadlines,
        ]);
    }
    
    public function create()
    {
        $tags = Tag::all();

        return view('dashboard.deadlines.create', ['tags' => $tags]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'pdf' => 'required|mimes:pdf|max:2048',
            'expiry_date' => 'required|date',
            'tags' => 'required|array',
        ]);    
        
        $deadline = Deadline::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        $deadline->tags()->attach($request->input('tags'));
        
        $pdfPath = $request->file('pdf')->store('pdfs');
        
        $documentName = $request->input('name');
        
        $deadline->documentDeadlines()->create([
            'name' => $documentName,
            'pdf_path' => $pdfPath,
            'expiry_date' => $request->input('expiry_date'),
        ]);
        
        return redirect()->route('dashboard.deadlines.index')->with('success', 'Scadenza aggiunta con successo!');
    }
    
    public function show($id)
    {
        $deadline = Deadline::findOrFail($id);
        
        return view('dashboard.deadlines.show', ['deadline' => $deadline]);
    }
    
    public function edit($id)
    {
        $deadline = Deadline::findOrFail($id);
        $deadline = Deadline::findOrFail($id);
        $tags = Tag::all();

        
        return view('dashboard.deadlines.edit', ['deadline' => $deadline, 'tags' => $tags]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'tags' => 'required|array',
            'pdf' => 'nullable|mimes:pdf|max:2048',
            'expiry_date' => 'required|date',
        ]);

        $deadline = Deadline::findOrFail($id);

        $deadline->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        $deadline->tags()->sync($request->input('tags'));

        $documentName = $request->input('name');
        $expiryDate = $request->input('expiry_date');

        if ($request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store('pdfs');
            $deadline->documentDeadlines()->update([
                'name' => $documentName,
                'pdf_path' => $pdfPath,
                'expiry_date' => $expiryDate,
            ]);
        } else {
            $deadline->documentDeadlines()->update([
                'name' => $documentName,
                'expiry_date' => $expiryDate,
            ]);
        }

        return redirect()->route('dashboard.deadlines.index')->with('success', 'Scadenza aggiornata con successo!');
    }
    
    public function destroy($id)
    {
        $deadline = Deadline::findOrFail($id);
        $deadline->delete();
        
        return redirect()->route('dashboard.deadlines.index')->with('success', 'Scadenza eliminata con successo!');
    }
    
    public function setExpiryDateAttribute($value)
    {
        $this->attributes['expiry_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // public function searchDeadlines(Request $request)
    //     {
    //         $deadlines = Deadline::search($request->searched)->get();
    //         $columnTitles = ["Nome", "Codice Fiscale", "Ruolo", "Documenti", "Modifica", "Elimina"];
        
    //         return view('dashboard.deadlines.index', compact('deadlines', 'columnTitles'));
    //     }
}
