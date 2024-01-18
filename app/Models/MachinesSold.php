<?php

namespace App\Models;

use App\Models\Ticket;
use App\Models\WarrantyType;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MachinesSold extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'model',
        'brand',
        'serial_number',
        'sale_date',
        'old_buyer',
        'buyer',
        'warranty_expiration_date',
        'warranty_type_id',
        'registration_date',
        'delivery_ddt',
        'notes'
    ];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'model' => $this->model,
            'brand' => $this->brand,
            'serial_number' => $this->serial_number,
            'sale_date' => $this->sale_date,
            'first_buyer' => $this->first_buyer,
            'current_owner' => $this->current_owner,
            'warranty_expiration_date' => $this->warranty_expiration_date,
            'warranty_type_id' => $this->warranty_type_id,
            'registration_date' => $this->registration_date,
            'delivery_ddt' => $this->delivery_ddt,
            'notes' => $this->notes
        ];
    }

    public function warrantyType()
    {
        return $this->belongsTo(WarrantyType::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'machine_sold_id');
    }

    public function ticketsModel()
    {
        return $this->hasMany(Ticket::class, 'machine_model_id');
    }
    
}
