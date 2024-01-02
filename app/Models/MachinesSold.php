<?php

namespace App\Models;

use App\Models\WarrantyType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MachinesSold extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'brand',
        'serial_number',
        'sale_date',
        'first_buyer',
        'current_owner',
        'warranty_expiration_date',
        'warranty_type_id',
        'registration_date',
        'delivery_ddt',
        'notes'
    ];

    public function warrantyType()
    {
        return $this->belongsTo(WarrantyType::class);
    }
    
}
