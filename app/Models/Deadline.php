<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\DocumentDeadline;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deadline extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'tag'];

    public function documentDeadlines()
    {
        return $this->hasMany(DocumentDeadline::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getStatus()
    {
        foreach ($this->documentDeadlines as $document) {
            $expiryDate = Carbon::parse($document->expiry_date);

            if ($expiryDate->isPast()) {
                return 'expired';
            } elseif ($expiryDate->diffInMonths(now()) <= 2) {
                return 'expiring_soon';
            }
        }

        return 'not_expired';
    }

    public function isExpired()
    {
        foreach ($this->documentDeadlines as $document) {
            $expiryDate = Carbon::parse($document->expiry_date);
            if ($expiryDate->isPast()) {
                return true;
            }
        }

        return false;
    }
}
