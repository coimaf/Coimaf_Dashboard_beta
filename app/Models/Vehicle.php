<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Maintenance;
use App\Models\TypeVehicle;
use App\Models\DocumentVehicle;
use App\Models\VehicleDocument;
use App\Models\DocumentVehicles;
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
    
}
