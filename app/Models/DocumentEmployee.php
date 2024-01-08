<?php

namespace App\Models;

use App\Models\Document;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentEmployee extends Model
{
    use HasFactory;

    protected $table = 'employee_document';

    protected $fillable = ['employee_id', 'document_id', 'pdf_path', 'expiry_date'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
