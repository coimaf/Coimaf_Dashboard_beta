<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Document;
use Laravel\Scout\Searchable;
use App\Models\DocumentEmployee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, Searchable;
    
    protected $fillable = ['name', 'surname', 'fiscal_code', 'birthday', 'phone', 'address', 'email', 'email_work'];
    
    public function toSearchableArray()
    {
        $documentEmployees = $this->documentEmployees;
        $array = [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'fiscal_code' => $this->fiscal_code,
            'birthday' => $this->birthday,
            'phone' => $this->phone,
            'address' => $this->address,
            'email' => $this->email,
            'email_work' => $this->email_work,
            'documentEmployees' => $documentEmployees,
        ];
        
        return $array;
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'employee_document')
        ->withPivot(['pdf_path', 'expiry_date']);
    }
    
    public function getDocumentStatuses()
    {
        $status = 'green';
        $icon = '';
        $tooltipText = '';
        $expiredDocuments = collect();
        $expiringDocuments = collect();
        
        foreach ($this->documents as $document) { // Corretto qui
            $expiryDate = Carbon::parse($document->pivot->expiry_date);
            
            if ($expiryDate->isPast()) {
                $expiredDocuments->push($document->name);
                $status = 'red';
            } elseif ($expiryDate->diffInDays(now()) <= 60 && $status !== 'red') {
                $status = 'yellow';
                $expiringDocuments->push($document->name);
            }
        }
        
        $icon = match ($status) {
            'red' => '<i class="bi bi-dash-circle-fill text-danger fs-3"></i>',
            'yellow' => '<i class="bi bi-exclamation-circle-fill text-warning fs-3"></i>',
            default => '<i class="bi bi-check-circle-fill text-success fs-3"></i>',
        };
        
        if ($expiredDocuments->isNotEmpty()) {
            $tooltipText .= 'Scaduti: ' . implode(', ', $expiredDocuments->toArray()) . "\n";
        }
        
        if ($expiringDocuments->isNotEmpty()) {
            $tooltipText .= 'Stanno per scadere: ' . implode(', ', $expiringDocuments->toArray()) . "\n";
        }
        
        return compact('icon', 'tooltipText');
    }
    
}
