<?php

namespace App\Models;

use App\Models\User;
use App\Models\Technician;
use App\Models\Replacement;
use App\Models\MachinesSold;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['updated_by','title', 'description', 'notes', 'descrizione', 'cd_cf', 'intervention_date', 'machine_model_id', 'machine_sold_id', 'closed', 'status', 'priority', 'pagato', 'rapportino', 'zona'];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'closed' => $this->closed,
            'notes' => $this->notes,
            'machine_sold_id' => $this->machine_sold_id,
            'machine_model_id' => $this->machine_model_id,
        ];
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function machinesSold()
    {
        return $this->belongsTo(MachinesSold::class, 'machine_sold_id');
    }

    public function machineModel()
    {
        return $this->belongsTo(MachinesSold::class, 'machine_model_id');
    }

    public static function getStatusOptions()
    {
        return ['Aperto', 'In lavorazione', 'In attesa di un ricambio', 'Da fatturare', 'Chiuso', 'Annullato'];
    }

    public static function getPriorityOptions()
    {
        return ['Bassa', 'Normale', 'Urgente'];
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function replacements(): HasMany
    {
        return $this->hasMany(Replacement::class);
    }
}
