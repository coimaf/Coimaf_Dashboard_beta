<?php

namespace App\Models;

use App\Models\User;
use App\Models\Technician;
use App\Models\MachinesSold;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['title', 'description', 'notes', 'descrizione', 'cd_cf', 'machine_model_id', 'machine_sold_id', 'closed', 'status', 'priority'];

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
        return ['Aperto', 'In lavorazione', 'In attesa di un ricambio', 'Da fatturare', 'Chiuso'];
    }

    public static function getPriorityOptions()
    {
        return ['Bassa', 'Normale', 'Urgente'];
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }
}
