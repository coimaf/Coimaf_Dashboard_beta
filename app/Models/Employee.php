<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'surname', 'fiscal_code', 'birthday', 'phone', 'address', 'email', 'email_work', 'role'];

    public function documents() {
        return $this->hasMany(Document::class);
    }
}
