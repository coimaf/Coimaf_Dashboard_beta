<?php

namespace App\Models;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleMaintenance extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_id', 'name', 'description', 'file', 'start_at', 'price'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    
}
