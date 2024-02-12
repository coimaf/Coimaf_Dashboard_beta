<?php

namespace App\Models;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Replacement extends Model
{
    use HasFactory;

    
    protected $fillable = ['art', 'desc', 'qnt', 'prz', 'sconto', 'tot','ticket_id'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
