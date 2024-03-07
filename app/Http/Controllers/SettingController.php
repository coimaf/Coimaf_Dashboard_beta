<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Role;
use App\Models\Document;
use App\Models\TypeVehicle;
use App\Models\WarrantyType;
use Illuminate\Http\Request;
use App\Models\DocumentVehicle;

class SettingController extends Controller
{
    public function index()
    {
        return view('dashboard.settings.index');
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

    public function machinesSoldsCreate()
    {
        $warrantyType = WarrantyType::all();
        return view('dashboard.settings.machinesSold.create', compact('warrantyType'));
    }

    public function machinesSoldsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:warranty_types|max:255',
        ]);

        WarrantyType::create(['name' => $request->name]);

        return redirect()->route('dashboard.settings.machinesSold.create')->with('success', 'Tipo di garanzia aggiunto con successo!');
    }

    public function machinesSoldsDelete($warrantyId)
    {
        $warranty = WarrantyType::find($warrantyId);
        $warranty->delete();

        return redirect()->route('dashboard.settings.machinesSold.create')->with('success', 'Tipo di garanzia  rimosso con successo!');
    }

    public function vehiclesCreate()
    {
        $vehicleTypes = TypeVehicle::all();
        return view('dashboard.settings.vehicle.create', compact('vehicleTypes'));
    }

    public function vehiclesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $vehicleTypes = TypeVehicle::create(['name' => $request->name]);

        return redirect()->route('dashboard.settings.vehicle.create')->with('success', 'Tipo di veicolo aggiunto con successo!');
    }
    
    public function vehiclesDelete($vehicleId)
    {
        $vehicle = TypeVehicle::find($vehicleId);
        $vehicle->delete();

        return redirect()->route('dashboard.settings.vehicle.create')->with('success', 'Tipo di veicolo rimosso con successo!');
    }
}
