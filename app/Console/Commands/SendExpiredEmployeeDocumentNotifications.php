<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Notifications\ScadenzaDocumentoEmployeeNotification;

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
        $this->sendNotificationsForExpiringDocuments(3);
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
                // Invia la notifica all'utente che ha creato la scadenza
                $employee->user->notify(new ScadenzaDocumentoEmployeeNotification($employee, 0)); // 0 giorni rimanenti per i documenti già scaduti
                // Invia la notifica all'indirizzo di amministrazione fittizio
                $adminUser = new User();
                $adminUser->email = 'amministrazione@coimaf.com';
                $adminUser->notify(new ScadenzaDocumentoEmployeeNotification($employee, 0));
                if ($employee->updatedBy) {
                    // Invia la notifica all'utente che ha aggiornato il documento
                    $employee->updatedBy->notify(new ScadenzaDocumentoEmployeeNotification($employee, 0)); // 0 giorni rimanenti per i documenti già scaduti
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
                // Invia la notifica all'utente che ha creato la scadenza
                $employee->user->notify(new ScadenzaDocumentoEmployeeNotification($employee, $days));
                // Invia la notifica all'indirizzo di amministrazione fittizio
                $adminUser = new User();
                $adminUser->email = 'amministrazione@coimaf.com';
                $adminUser->notify(new ScadenzaDocumentoEmployeeNotification($employee, $days));
                if ($employee->updatedBy) {
                    // Invia la notifica all'utente che ha aggiornato il documento
                    $employee->updatedBy->notify(new ScadenzaDocumentoEmployeeNotification($employee, $days));
                }
            }
        }
    }
}
