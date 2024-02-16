<?php

namespace App\Models;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleDocument extends Model
{
    use HasFactory;

    protected $fillable = [ 'vehicle_id', 'name', 'file', 'date_start', 'expiry_date' ];
    
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    
}
