<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class SendExpiredEmployeeDocumentNotifications extends Command
{
    protected $signature = 'send:expired-employee-document-notifications';
    
    protected $description = 'Send notifications for expired employee documents';
    
    public function handle()
    {
        // Invia le notifiche per i documenti già scaduti
        $this->sendExpiredDocumentsNotification();

        // Invia le notifiche per i documenti in scadenza entro 60, 30 e 7 giorni
        $this->sendNotificationsForExpiringDocuments(60);
        $this->sendNotificationsForExpiringDocuments(30);
        $this->sendNotificationsForExpiringDocuments(7);
    }
    
    private function sendExpiredDocumentsNotification()
    {
        // Trova tutti gli impiegati con documenti già scaduti
        $employees = Employee::with('user', 'updatedBy')
            ->whereHas('documents', function ($query) {
                $query->where('expiry_date', '<', now()->format('Y-m-d'));
            })
            ->get();

        foreach ($employees as $employee) {
            if ($employee->user) {
                $employee->user->notify(new \App\Notifications\ScadenzaDocumentoEmployeeNotification($employee, 0)); // 0 giorni rimanenti per i documenti già scaduti
                Mail::to('amministrazione@coimaf.com')->send(new \App\Notifications\ScadenzaDocumentoEmployeeNotification($employee, 0));
                // Mail::to('operativo@coimaf.com')->send(new \App\Notifications\ScadenzaDocumentoEmployeeNotification($employee, 0));
                if ($employee->updatedBy) {
                    $employee->updatedBy->notify(new \App\Notifications\ScadenzaDocumentoEmployeeNotification($employee, 0)); // 0 giorni rimanenti per i documenti già scaduti
                }
            }
        }
    }

    private function sendNotificationsForExpiringDocuments($days)
    {
        // Trova tutti gli impiegati con documenti che scadono entro $days giorni
        $employees = Employee::with('user', 'updatedBy')
            ->whereHas('documents', function ($query) use ($days) {
                $query->where('expiry_date', '=', now()->addDays($days)->format('Y-m-d'));
            })
            ->get();

        foreach ($employees as $employee) {
            if ($employee->user) {
                $employee->user->notify(new \App\Notifications\ScadenzaDocumentoEmployeeNotification($employee, $days));
                Mail::to('amministrazione@coimaf.com')->send(new \App\Notifications\ScadenzaDocumentoEmployeeNotification($employee, 0));
                // Mail::to('operativo@coimaf.com')->send(new \App\Notifications\ScadenzaDocumentoEmployeeNotification($employee, $days));
                if ($employee->updatedBy) {
                    $employee->updatedBy->notify(new \App\Notifications\ScadenzaDocumentoEmployeeNotification($employee, $days));
                }
            }
        }
    }
}
