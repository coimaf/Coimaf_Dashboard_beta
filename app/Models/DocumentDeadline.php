<?php

namespace App\Models;

use App\Models\Deadline;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentDeadline extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'pdf_path', 'expiry_date'];

    public function deadline() {
        return $this->belongsTo(Deadline::class);
    }
}
