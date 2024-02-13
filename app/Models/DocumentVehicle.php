<?php

namespace App\Models;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentVehicle extends Model
{
    use HasFactory;
    protected $table = 'document_vehicles';

    protected $fillable = ['name'];

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'document_vehicle')
            ->withPivot('path', 'expiry_date');
    }
}
