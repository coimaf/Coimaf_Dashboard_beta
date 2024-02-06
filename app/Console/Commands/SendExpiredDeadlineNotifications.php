<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Deadline;
use Illuminate\Support\Facades\Cache;

class SendExpiredDeadlineNotifications extends Command
{
    protected $signature = 'send:expired-deadline-notifications';

    protected $description = 'Send notifications for expired deadlines';

    public function handle()
    {
        // Trova tutte le scadenze scadute
        $expiredDeadlines = Deadline::whereHas('documentDeadlines', function ($query) {
            $query->where('expiry_date', '<', now());
        })->get();    

        // Invia le notifiche per le scadenze scadute
        foreach ($expiredDeadlines as $deadline) {
            $recipients = collect([$deadline->user]);
            if ($deadline->updated_by) {
                $recipients->push($deadline->updatedBy);
            }

            foreach ($recipients as $recipient) {
                if ($recipient) {
                    // Ottieni la data di scadenza del primo documento associato
                    $expiryDate = $deadline->documentDeadlines->first()->expiry_date;
                    $recipient->notify(new \App\Notifications\ScadenzaScadutaNotification($deadline, $expiryDate));
                }
            }
        }
    }    
    
}
