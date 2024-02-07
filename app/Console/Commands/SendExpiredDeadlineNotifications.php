<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Deadline;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class SendExpiredDeadlineNotifications extends Command
{
    protected $signature = 'send:expired-deadline-notifications';
    
    protected $description = 'Send notifications for expired deadlines';
    
    public function handle()
    {
        // Trova tutte le scadenze scadute o future
        $deadlines = Deadline::whereHas('documentDeadlines', function ($query) {
            $query->where('expiry_date', '<=', now()->addDays(60)); // Aggiungi giorni per includere anche le scadenze a 60 giorni
            $query->orWhere('expiry_date', '<=', now()->addDays(30)); // Aggiungi giorni per includere anche le scadenze a 30 giorni
            $query->orWhere('expiry_date', '<=', now()->addDays(7)); // Aggiungi giorni per includere anche le scadenze a 7 giorni
        })->get();    
        
        foreach ($deadlines as $deadline) {
            // Calcola i giorni rimanenti fino alla scadenza
            $expiryDate = Carbon::parse($deadline->documentDeadlines->first()->expiry_date);
            $daysRemaining = now()->diffInDays($expiryDate, false);
            
            // Invia la notifica se ci sono meno di 60, 30 o 7 giorni alla scadenza oppure se è già scaduta
            if ($daysRemaining <= 0 || $daysRemaining <= 7 || $daysRemaining <= 30 || $daysRemaining <= 60) {
                $this->sendNotification($deadline, $daysRemaining);
                $this->sendNotificationToUpdatedBy($deadline, $daysRemaining);
            }
        }
    }
    
    
    private function sendNotification(Deadline $deadline, int $daysRemaining)
    {
        $deadline->user->notify(new \App\Notifications\ScadenzaScadutaNotification($deadline, $daysRemaining));
    }
    
    private function sendNotificationToUpdatedBy(Deadline $deadline, int $daysRemaining)
    {
        if ($deadline->updated_by) {
            $deadline->updatedBy->notify(new \App\Notifications\ScadenzaScadutaNotification($deadline, $daysRemaining));
        }
    }
}
