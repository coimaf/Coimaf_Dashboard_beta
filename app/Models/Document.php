<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'pdf_file'];

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivot('expiry_date');
    }
}
