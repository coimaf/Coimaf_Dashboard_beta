<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'expiry_date'];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
