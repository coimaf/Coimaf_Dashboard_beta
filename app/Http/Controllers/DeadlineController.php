<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Deadline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;

class DeadlineController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sortBy', 'default');
        $direction = $request->input('direction', 'asc');
        
        $columnTitles = [ [
            'text' => 'Nome Documento',
            'sortBy' => 'name',
        ],
        [
            'text' => 'Scadenza',
            'sortBy' => 'expiry_date',
        ],"Tag", "Modifica", "Elimina"];

        $routeName = 'dashboard.deadlines.index';
        
        $query = Deadline::with(['documentDeadlines']);
        
        if ($sortBy == 'expiry_date') {
            $query->join('document_deadlines', 'deadlines.id', '=', 'document_deadlines.deadline_id')
            ->orderBy('document_deadlines.expiry_date', $direction)
            ->select('deadlines.*');
        } elseif ($sortBy == 'name') {
            $query->orderBy('deadlines.name', $direction);
        }
        
        $deadlines = $query->get();
        
        return view('dashboard.deadlines.index', [
            'columnTitles' => $columnTitles,
            'deadlines' => $deadlines,
            'sortBy' => $sortBy,
            'direction' => $direction,
            'routeName' => $routeName
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
            'tags' => 'array',
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
        
        Auth::user()->deadlines()->save($deadline);
        
        return redirect()->route('dashboard.deadlines.index')->with('success', 'Scadenza aggiunta con successo!');
    }
    
    public function show($id)
    {
        $deadline = Deadline::findOrFail($id);
        
        return view('dashboard.deadlines.show', ['deadline' => $deadline]);
    }
    
    public function edit($id)
    {
        $deadline = Deadline::with('documentDeadlines')->findOrFail($id);
        $tags = Tag::all();
        
        
        return view('dashboard.deadlines.edit', ['deadline' => $deadline, 'tags' => $tags]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'tags' => 'array',
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
}
