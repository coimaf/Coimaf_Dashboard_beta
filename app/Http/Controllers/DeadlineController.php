<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Deadline;
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
        return view('dashboard.deadlines.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'tag' => 'required|string|max:255',
            'pdf' => 'required|mimes:pdf|max:2048',
            'expiry_date' => 'required|date',
        ]);
        
        $deadline = Deadline::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'tag' => $request->input('tag'),
        ]);
        
        $pdfPath = $request->file('pdf')->store('pdfs'); // Salva il file nella cartella 'storage/app/pdfs'
        
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
        
        return view('dashboard.deadlines.edit', ['deadline' => $deadline]);
    }
    
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'tag' => 'required|string|max:255',
        'expiry_date' => 'required|date_format:d-m-Y',
        'pdf' => 'nullable|mimes:pdf|max:2048',
    ]);

    $deadline = Deadline::findOrFail($id);
    $deadline->update($request->only(['name', 'description', 'tag', 'expiry_date']));

    // Carica un nuovo documento solo se fornito
    if ($request->hasFile('pdf')) {
        $pdfPath = $request->file('pdf')->store('pdfs');
        $deadline->pdf_path = $pdfPath;
        $deadline->save();
    }

    return redirect()->route('dashboard.deadlines.index')->with('success', 'Documento aggiornato con successo.');
}

    
    
    public function destroy($id)
    {
        $deadline = Deadline::findOrFail($id);
        $deadline->delete();
        
        return redirect()->route('dashboard.deadlines.index')->with('success', 'Scadenza eliminata con successo!');
    }
    
    public function setExpiryDateAttribute($value)
    {
        // Parse the incoming date and set it in the desired format
        $this->attributes['expiry_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }
    
}
