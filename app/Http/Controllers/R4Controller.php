<?php

namespace App\Http\Controllers;

use App\Models\R4;
use App\Models\TypeR4;
use App\Models\R4Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class R4Controller extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index(Request $request, R4 $r4)
    {
        $columnTitles = [
            ['text' => 'Nome', 'sortBy' =>  'name'],
            'Tipo',
            ['text' => 'Matricola', 'sortBy' => 'serial_number'],
            ['text' => 'Assegnato a', 'sortBy' => 'assigned_to'],
            ['text' => 'Frequenza Controllo', 'sortBy' => 'control_frequency'],
            ['text' => 'Data Acquisto', 'sortBy' => 'buy_date'],
            'Documenti',
            'Modifica',
            'Elimina'
        ];
        
        $r4s = R4::all();
        $queryBuilder = R4::with(['TypeR4']);
        $searchTerm = $request->input('r4Search');
        
        
        $sortBy = $request->input('sortBy', 'default');
        $direction = $request->input('direction', 'asc');
        $routeName = 'dashboard.fpc.r4.index';
        
        if ($searchTerm) {
            $queryBuilder->where('name', 'like', '%' . $searchTerm . '%')
            ->orWhere('serial_number', 'LIKE', "%$searchTerm%")
            ->orWhere('assigned_to', 'LIKE', "%$searchTerm%")
            ->orWhere('control_frequency', 'LIKE', "%$searchTerm%")
            ->orWhereHas('TypeR4', function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%$searchTerm%");
            });
        }
        
        $queryBuilder->when($sortBy == 'name', function ($query) use ($direction) {
            $query->orderBy('name', $direction);
        })->when($sortBy == 'serial_number', function ($query) use ($direction) {
            $query->orderBy('serial_number', $direction);
        })->when($sortBy == 'assigned_to', function ($query) use ($direction) {
            $query->orderBy('assigned_to', $direction);
        })->when($sortBy == 'control_frequency', function ($query) use ($direction) {
            $query->orderBy('control_frequency', $direction);
        })->when($sortBy == 'buy_date', function ($query) use ($direction) {
            $query->orderBy('buy_date', $direction);
        })->when($sortBy == 'TypeR4', function ($query) use ($direction) {
            $query->join('type_r4_s', 'type_r4_id', '=', 'type_r4.id')
            ->orderBy('type_r4.name', $direction);
        });
        
        $r4s = $queryBuilder->paginate(24)->appends([
            'r4Search' => $searchTerm,
        ]);
        
        return view('dashboard.fpc.r4.index', compact(
            'r4s',
            'columnTitles',
            'sortBy',
            'direction',
            'routeName')); 
        }
        
        /**
        * Show the form for creating a new resource.
        */
        public function create()
        {
            $typer4 = TypeR4::all();
            return view( 'dashboard.fpc.r4.create', compact('typer4'));
        }
        
        /**
        * Store a newly created resource in storage.
        */
        public function store(Request $request)
        {
            $r4 = R4::create($request->all());
            
            $r4->TypeR4()->associate($request->input('type_r4_id'));
            
            $r4->user()->associate(Auth::user());
            
            $r4->save();
            
            // Se sono stati forniti documenti, li elabora
            if ($request->filled('document_name')) {
                foreach ($request->input('document_name') as $key => $documentName) {
                    if (!empty($documentName)) {
                        $document = new R4Document();
                        $document->name = $documentName;
                        
                        // Se è fornito un file, lo salva con un nome personalizzato
                        if ($request->hasFile('document_file.' . $key)) {
                            // Ottieni il file dalla richiesta
                            $file = $request->file('document_file.' . $key);
                            
                            // Ottieni l'estensione del file
                            $ext = $file->extension();
                            
                            // Genera il nome personalizzato combinando il nome del documento, la data corrente e l'estensione del file
                            $customName = $documentName . '_' . now()->format('d_m_Y_H_i') . '.' . $ext;
                            
                            // Salva il file con il nome personalizzato
                            $document->file = $file->storeAs('FPC_R4', $customName, 'public');
                        }
                        
                        $document->date_start = $request->input('document_date_start.' . $key); // Campo data di inizio
                        $document->expiry_date = $request->input('document_expiry_date.' . $key); // Campo data di scadenza
                        $document->r4_id = $r4->id;
                        $document->save();
                    }
                }            
            }
            
            
            return redirect()->route('dashboard.fpc.r4.index')->with('success', 'R4 creato correttamente');
        }
        
        /**
        * Display the specified resource.
        */
        public function show(R4 $r4)
        {
            return view('dashboard.fpc.r4.show', compact('r4'));
        }
        
        /**
        * Show the form for editing the specified resource.
        */
        public function edit(R4 $r4)
        {
            $typer4 = TypeR4::all();
            return view('dashboard.fpc.r4.edit', compact('r4', 'typer4'));
        }
        
        /**
        * Update the specified resource in storage.
        */
        public function update(Request $request, R4 $r4)
        {
            $r4->update($request->all());
            
            $r4->TypeR4()->associate($request->input('type_r4_id'));
            
            $r4->updated_by_id = Auth::user()->id;
            
            $r4->save();
            
            // Se sono stati forniti documenti esistenti, li aggiorna
            if ($request->filled('document_id')) {
                foreach ($request->input('document_id') as $key => $documentId) {
                    // Trova il documento esistente
                    $document = R4Document::findOrFail($documentId);
                    
                    // Modifica solo se sono stati forniti nuovi dati
                    if ($request->hasFile('document_file.' . $key)) {
                        // Ottieni il file dalla richiesta
                        $file = $request->file('document_file.' . $key);
                        
                        // Ottieni l'estensione del file
                        $ext = $file->extension();
                        
                        // Genera il nome personalizzato combinando il nome del documento, la data corrente e l'estensione del file
                        $customName = $document->name . '_' . now()->format('d_m_Y_H_i') . '.' . $ext;
                        
                        // Salva il file con il nome personalizzato
                        $document->file = $file->storeAs('FPC_R4', $customName, 'public');
                    }
                    
                    $document->name = $request->input('document_name.' . $key);
                    $document->date_start = $request->input('document_date_start.' . $key);
                    $document->expiry_date = $request->input('document_expiry_date.' . $key);
                    $document->save();
                }
            }
            
            // Se sono stati forniti nuovi documenti, li salva
            if ($request->filled('new_document_name')) {
                foreach ($request->input('new_document_name') as $key => $documentName) {
                    // Crea un nuovo documento
                    $newDocument = new R4Document();
                    $newDocument->name = $documentName;
                    $newDocument->date_start = $request->input('new_document_date_start.' . $key);
                    $newDocument->expiry_date = $request->input('new_document_expiry_date.' . $key);
                    
                    // Se è fornito un file, lo salva con un nome personalizzato
                    if ($request->hasFile('new_document_file.' . $key)) {
                        // Ottieni il file dalla richiesta
                        $file = $request->file('new_document_file.' . $key);
                        
                        // Ottieni l'estensione del file
                        $ext = $file->extension();
                        
                        // Genera il nome personalizzato combinando il nome del documento, la data corrente e l'estensione del file
                        $customName = $documentName . '_' . now()->format('d_m_Y_H_i') . '.' . $ext;
                        
                        // Salva il file con il nome personalizzato
                        $newDocument->file = $file->storeAs('FPC_R4', $customName, 'public');
                    }
                    
                    // Associa il documento al r4
                    $newDocument->r4_id = $r4->id;
                    $newDocument->save();
                }
            }
            
            
            
            return redirect()->route('dashboard.fpc.r4.index')->with('success', 'R4 aggiornato correttamente');
        }
        
        /**
        * Remove the specified resource from storage.
        */
        public function destroy(R4 $r4)
        {
            $r4->delete();
            return redirect()->route('dashboard.fpc.r4.index')->with('success', 'R4 eliminato correttamente');
        }
    }
    