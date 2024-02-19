<?php

namespace App\Models;

use App\Models\User;
use App\Models\TypeR4;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class R4 extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type_r4_id',
        'serial_number',
        'assigned_to',
        'control_frequency',
        'description',
        'buy_date',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function TypeR4() 
    {
        return $this->belongsTo(TypeR4::class);
    }
}
