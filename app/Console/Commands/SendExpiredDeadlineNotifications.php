<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Deadline;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Notifications\ScadenzaScadutaNotification;

class SendExpiredDeadlineNotifications extends Command
{
    protected $signature = 'send:expired-deadline-notifications';
    
    protected $description = 'Send notifications for expired deadlines';
    
    public function handle()
    {
        // Trova tutte le scadenze scadute o con scadenza entro 60, 30 e 7 giorni
        $deadlines = Deadline::whereHas('documentDeadlines', function ($query) {
            $query->where('expiry_date', '<=', now()->addDays(60)->format('Y-m-d'))
                  ->orWhere('expiry_date', '<=', now()->addDays(30)->format('Y-m-d'))
                  ->orWhere('expiry_date', '<=', now()->addDays(7)->format('Y-m-d'))
                  ->orWhere('expiry_date', '<=', now()->addDays(3)->format('Y-m-d'));
        })->get();    
        
        foreach ($deadlines as $deadline) {
            // Calcola i giorni rimanenti fino alla scadenza
            $expiryDate = Carbon::parse($deadline->documentDeadlines->first()->expiry_date);
            $daysRemaining = now()->diffInDays($expiryDate, false);
            
            // Invia la notifica solo se mancano 60, 30 o 7 giorni alla scadenza oppure se è già scaduta
            if ($daysRemaining <= 0 || $daysRemaining === 3 || $daysRemaining === 6 || $daysRemaining === 29 || $daysRemaining === 59) {
                $this->sendNotification($deadline, $daysRemaining);
                $this->sendNotificationToUpdatedBy($deadline, $daysRemaining);
            }
        }
    }
    
    

    private function sendNotification(Deadline $deadline, int $daysRemaining)
    {
        // Ottieni l'utente che ha creato la scadenza
        $user = $deadline->user;
    
        // Verifica se l'utente esiste e ha un indirizzo email
        if ($user && $user->email) {
            // Invia la notifica all'utente che ha creato la scadenza
            $user->notify(new ScadenzaScadutaNotification($deadline, $daysRemaining));
        }
    
        // Invia la notifica anche all'indirizzo di amministrazione
        $adminUser = new User();
        $adminUser->email = 'amministrazione@coimaf.com';
        $adminUser->notify(new ScadenzaScadutaNotification($deadline, $daysRemaining));
    }
    
    private function sendNotificationToUpdatedBy(Deadline $deadline, int $daysRemaining)
    {
        if ($deadline->updated_by) {
            $deadline->updatedBy->notify(new \App\Notifications\ScadenzaScadutaNotification($deadline, $daysRemaining));
        }
    }
}
