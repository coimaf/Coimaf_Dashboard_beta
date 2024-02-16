<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Maintenance;
use App\Models\TypeVehicle;
use App\Models\DocumentVehicle;
use App\Models\VehicleDocument;
use App\Models\DocumentVehicles;
use App\Models\VehicleMaintenance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;
    
    
    protected $fillable =  [
        'brand',
        'model',
        'license_plate',
        'chassis',
        'registration_year',
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }
    
    public function TypeVehicle() 
    {
        return $this->belongsTo(TypeVehicle::class);
    }
    
    public function documents()
    {
        return $this->hasMany(VehicleDocument::class);
    }

    public function maintenances()
    {
        return $this->hasMany(VehicleMaintenance::class);
    }
    
    public function getDocumentStatuses()
    {
        $status = 'green';
        $icon = '';
        $tooltipText = '';
        $expiredDocuments = collect();
        $expiringDocuments = collect();
        $daysRemaining = 0;
    
        foreach ($this->documents as $document) {
            $expiryDate = Carbon::parse($document->expiry_date);
    
            if ($expiryDate->isPast()) {
                $expiredDocuments->push($document->name);
            } elseif ($expiryDate->diffInDays(now()) <= 60 && $status !== 'red') {
                $status = 'yellow';
                $expiringDocuments->push($document->name);
            }
    
            // Calcola i giorni rimanenti fino alla scadenza
            $daysRemaining = now()->diffInDays($expiryDate, false);
        }
    
        // Se ci sono documenti scaduti, assegna la priorità dell'icona a 'red'
        if ($expiredDocuments->isNotEmpty()) {
            $status = 'red';
        }
    
        $icon = match ($status) {
            'red' => '<i class="bi bi-dash-circle-fill text-danger fs-3"></i>',
            'yellow' => '<i class="bi bi-exclamation-circle-fill text-warning fs-3"></i>',
            default => '<i class="bi bi-check-circle-fill text-success fs-3"></i>',
        };
    
        // Aggiungi i nomi dei documenti scaduti e di quelli che stanno per scadere al tooltip
        if ($expiredDocuments->isNotEmpty()) {
            $tooltipText .= 'Scaduti: ' . implode(', ', $expiredDocuments->toArray()) . "\n";
        }
    
        if ($expiringDocuments->isNotEmpty()) {
            $tooltipText .= 'Stanno per scadere: ' . implode(', ', $expiringDocuments->toArray()) . "\n";
        }
    
        // Restituisci un array contenente 'icon', 'tooltipText' e 'daysRemaining'
        return compact('icon', 'tooltipText', 'daysRemaining');
    }
    
}
