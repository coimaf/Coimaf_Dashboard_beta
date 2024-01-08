<?php

namespace App\Models;

use App\Models\Employee;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['name', 'pdf_file'];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'pdf_file' => $this->pdf_file
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivot('expiry_date');
    }
}
