<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Document;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['name', 'surname', 'fiscal_code', 'birthday', 'phone', 'address', 'email', 'email_work', 'role'];

    public function toSearchableArray()
    {
        $documents = $this->documents;
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
            'role' => $this->role,
            'documents' => $documents
        ];

        return $array;
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }

    public function getDocumentStatuses()
    {
        $status = 'green';
        $icon = '';
        $tooltipText = '';
        $expiredDocuments = collect();
        $expiringDocuments = collect();

        foreach ($this->documents as $document) {
            $expiryDate = Carbon::parse($document->expiry_date);

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
            default => "<i class='bi bi-check-circle-fill text-success fs-3'></i>",
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
