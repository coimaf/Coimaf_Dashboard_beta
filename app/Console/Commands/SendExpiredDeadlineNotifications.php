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
    $expiredDeadlines = Deadline::whereHas('documentDeadlines', function ($query) {
        $query->where('document_deadlines.expiry_date', '<', now());
    })->get();    

    foreach ($expiredDeadlines as $deadline) {
        $cacheKey = 'scadenza_scaduta_' . $deadline->id;

        if (!Cache::has($cacheKey)) {
            $recipients = collect([$deadline->user]);
            if ($deadline->updated_by) {
                $recipients->push($deadline->updatedBy);
            }

            foreach ($recipients as $recipient) {
                if ($recipient) {
                    $expiryDate = $deadline->documentDeadlines->first()->expiry_date;
                    $recipient->notify(new \App\Notifications\ScadenzaScadutaNotification($deadline, $expiryDate));
                }
            }

            Cache::put($cacheKey, true, now()->endOfDay());
        }
    }
}
    
}
