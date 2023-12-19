<?php

namespace App\Http\Controllers;

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
    public function create()
    {
        $roles = Role::all();
        $documents = Document::all();
    
        return view('dashboard.settings.employees.create', compact('roles', 'documents'));
    }

    public function manageDocument(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'document_id' => 'required|exists:documents,id',
            'action' => 'required|in:associate,dissociate',
        ]);

        $role = Role::find($request->input('role_id'));
        $document = Document::find($request->input('document_id'));

        if ($request->input('action') === 'associate') {
            // Associa il documento al ruolo
            $role->documents()->attach($document->id);
            $message = 'Documento associato con successo!';
        } else {
            // Dissocia il documento dal ruolo
            $role->documents()->detach($document->id);
            $message = 'Documento dissociato con successo!';
        }

        return redirect()->route('dashboard.settings.employees.create')->with('success', $message);
    }

    
    public function addRole(Request $request)
    {
        $request->validate([
            'role_name' => 'required|unique:roles,name',
        ]);
    
        Role::create(['name' => $request->input('role_name')]);
    
        return redirect()->route('dashboard.settings.employees.create')->with('success', 'Ruolo aggiunto con successo!');
    }
    
    public function removeRole($roleId)
    {
        $role = Role::find($roleId);
        $role->delete();
    
        return redirect()->route('dashboard.settings.employees.create')->with('success', 'Ruolo rimosso con successo!');
    }
    
    public function addDocument(Request $request)
    {
        $request->validate([
            'document_name' => 'required|unique:documents,name',
        ]);
    
        Document::create(['name' => $request->input('document_name')]);
    
        return redirect()->route('dashboard.settings.employees.create')->with('success', 'Documento aggiunto con successo!');
    }
    
    public function removeDocument($documentId)
    {
        $document = Document::find($documentId);
        $document->delete();
    
        return redirect()->route('dashboard.settings.employees.create')->with('success', 'Documento rimosso con successo!');
    }
}
