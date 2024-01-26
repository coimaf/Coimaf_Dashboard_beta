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
        $searchTerm = $request->input('deadlineSearch');
        $screenWidth = $request->input('screenWidth');
    
        $columnTitles = [
            [
                'text' => 'Nome Documento',
                'sortBy' => 'name',
            ],
            [
                'text' => 'Scadenza',
                'sortBy' => 'expiry_date',
            ],
            "Tag", "Modifica", "Elimina"
        ];
    
        $routeName = 'dashboard.deadlines.index';
    
        $queryBuilder = Deadline::with(['documentDeadlines']);
    
        if ($searchTerm) {
            $queryBuilder->where('deadlines.name', 'like', '%' . $searchTerm . '%')
                ->orWhere('description', 'LIKE', "%$searchTerm%")
                ->orWhereHas('tags', function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', "%$searchTerm%");
                });
        }
    
        if ($sortBy == 'expiry_date') {
            $queryBuilder->join('document_deadlines', 'deadlines.id', '=', 'document_deadlines.deadline_id')
                ->orderBy('document_deadlines.expiry_date', $direction)
                ->select('deadlines.*');
        } elseif ($sortBy == 'name') {
            $queryBuilder->orderBy('deadlines.name', $direction);
        }
    
        // Determine items per page based on screen width
        $itemsPerPage = $screenWidth >= 1600 ? 50 : ($screenWidth >= 768 ? 18 : 18);
    
        $deadlines = $queryBuilder->paginate($itemsPerPage);
    
        // Paginazione con i parametri di ricerca
        $deadlines->appends([
            'sortBy' => $sortBy,
            'direction' => $direction,
            'deadlineSearch' => $searchTerm,
        ]);
    
        return view('dashboard.deadlines.index', [
            'columnTitles' => $columnTitles,
            'deadlines' => $deadlines,
            'sortBy' => $sortBy,
            'direction' => $direction,
            'routeName' => $routeName,
        ]);
    }
    
    
    public function showByTag($tag)
    {
        $sortBy = 'default'; // Set the default sorting value
        $direction = 'asc'; // Set the default sorting direction
    
        $columnTitles = [
            [
                'text' => 'Nome Documento',
                'sortBy' => 'name',
            ],
            [
                'text' => 'Scadenza',
                'sortBy' => 'expiry_date',
            ],
            "Tag", "Modifica", "Elimina"
        ];
    
        $routeName = 'dashboard.deadlines.index';
    
        $queryBuilder = Deadline::whereHas('tags', function ($query) use ($tag) {
            $query->where('name', $tag);
        });
    
        // Add sorting logic if needed
    
        $deadlines = $queryBuilder->paginate(19);
    
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
            'pdf' => 'required|mimes:pdf|max:2048',
            'expiry_date' => 'required|date',
        ]);    
        
        $deadline = Deadline::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        
        $deadline->tags()->attach($request->input('tags'));
        
        $pdfPath = $request->file('pdf')->store('pdfs', 'public');
        
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
            $pdfPath = $request->file('pdf')->store('pdfs', 'public');
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

        
        $lastModifiedUser = Auth::user();
        $deadline->updated_by = $lastModifiedUser->name;
        $deadline->save();
        
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
