<?php

namespace App\Models;

use App\Models\R4;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class R4Document extends Model
{
    use HasFactory;

    protected $fillable = [ 'r4_id', 'name', 'file', 'date_start', 'expiry_date' ];
    
    public function r4()
    {
        return $this->belongsTo(R4::class);
    }
}
