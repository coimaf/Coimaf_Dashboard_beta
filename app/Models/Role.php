<?php

namespace App\Models;

use App\Models\Document;
use App\Models\Employee;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['name'];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }    

    public function documents()
    {
        return $this->belongsToMany(Document::class)->withPivot('expiry_date');
    }
    
}
