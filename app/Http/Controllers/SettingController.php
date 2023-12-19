<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Role;
use App\Models\Document;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $documents = Document::all();
        
        return view('dashboard.settings.index', compact('roles', 'documents'));
    }
    public function employeesCreate()
    {
        $roles = Role::all();
        $documents = Document::all();
        
        return view('dashboard.settings.employees.create', compact('roles', 'documents'));
    }
    
    public function employeesManageDocument(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'document_id' => 'required|exists:documents,id',
            'action' => 'required|in:associate,dissociate',
        ]);
        
        $role = Role::find($request->input('role_id'));
        $document = Document::find($request->input('document_id'));
        
        if ($request->input('action') === 'associate') {
            // Verifica se il documento è già associato al ruolo
            if (!$role->documents->contains($document->id)) {
                // Associa il documento al ruolo solo se non è già associato
                $role->documents()->attach($document->id);
                $messageType = 'success';
                $message = 'Documento associato con successo!';
            } else {
                $messageType = 'error';
                $message = 'Il documento è già associato al ruolo!';
            }
        } else {
            // Dissocia il documento dal ruolo solo se è associato
            if ($role->documents->contains($document->id)) {
                $role->documents()->detach($document->id);
                $messageType = 'success';
                $message = 'Documento dissociato con successo!';
            } else {
                $messageType = 'error';
                $message = 'Il documento non è associato al ruolo!';
            }
        }
        
        $redirectRoute = $messageType === 'success' ? 'dashboard.settings.employees.create' : 'dashboard.settings.employees.create';
        
        return redirect()->route($redirectRoute)->with($messageType, $message);
    }
    
    public function employeesAddRole(Request $request)
    {
        $roleName = $request->input('role_name');
    
        // Verifica se il ruolo già esiste
        if (!Role::where('name', $roleName)->exists()) {
            
            Role::create(['name' => $roleName]);
            $messageType = 'success';
            $message = 'Ruolo aggiunto con successo!';
        } else {
            $messageType = 'error';
            $message = 'Il ruolo già esiste!';
            session()->flash('error', 'Questo è un messaggio di errore di debug.');
        }
    
        return redirect()->route('dashboard.settings.employees.create')->with($messageType, $message);
    }
    
    
    public function employeesRemoveRole($roleId)
    {
        $role = Role::find($roleId);
    
        // Verifica se il ruolo esiste
        if ($role) {
            $role->delete();
            $messageType = 'success';
            $message = 'Ruolo rimosso con successo!';
        } else {
            $messageType = 'error';
            $message = 'Il ruolo non esiste!';
        }
    
        return redirect()->route('dashboard.settings.employees.create')->with($messageType, $message);
    }
    
    public function employeesAddDocument(Request $request)
    {
        $documentName = $request->input('document_name');
    
        // Verifica se il documento già esiste
        if (!Document::where('name', $documentName)->exists()) {
            Document::create(['name' => $documentName]);
            $messageType = 'success';
            $message = 'Documento aggiunto con successo!';
        } else {
            $messageType = 'error';
            $message = 'Il documento già esiste!';
        }
    
        return redirect()->route('dashboard.settings.employees.create')->with($messageType, $message);
    }
    
    public function employeesRemoveDocument($documentId)
    {
        $document = Document::find($documentId);
    
        // Verifica se il documento esiste
        if ($document) {
            $document->delete();
            $messageType = 'success';
            $message = 'Documento rimosso con successo!';
        } else {
            $messageType = 'error';
            $message = 'Il documento non esiste!';
        }
    
        return redirect()->route('dashboard.settings.employees.create')->with($messageType, $message);
    }

    public function deadlinesCreate()
    {
        $tags = Tag::all();
        
        return view('dashboard.settings.deadlines.create', compact('tags'));
    }

    public function deadlinesAddTag(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tags',
        ]);

        Tag::create(['name' => $request->input('name')]);

        return redirect()->route('dashboard.settings.deadlines.create')->with('success', 'Tag aggiunto con successo!');
    }

    public function deadlinesRemoveTag($tagId)
    {
        $tag = Tag::find($tagId);
        $tag->delete();

        return redirect()->route('dashboard.settings.deadlines.create')->with('success', 'Tag rimosso con successo!');
    }
    
}
