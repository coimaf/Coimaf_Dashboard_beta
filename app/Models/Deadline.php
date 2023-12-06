<?php

namespace App\Models;

use App\Models\DocumentDeadline;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deadline extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'tag'];

    public function documentDeadlines() {
        return $this->hasMany(DocumentDeadline::class);
    }
}
