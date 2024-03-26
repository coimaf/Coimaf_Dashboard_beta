<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Console\Command;
use App\Notifications\ScadenzaDocumentoVehicleNotification;

class SendExpiredVehicleNotifications extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'send:expired-vehicle-notifications';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Send notifications for expired vehicles documents';
    
    /**
    * Execute the console command.
    */
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
        $vehicles = Vehicle::with('user', 'updatedBy')
        ->whereHas('documents', function ($query) {
            $query->where('expiry_date', '<', now()->format('Y-m-d'));
        })
        ->orWhereHas('maintenances', function ($subquery) {
            $subquery->where('end_at', '<', now()->format('Y-m-d'));
        })
        ->get();
        
        foreach ($vehicles as $vehicle) {
            if ($vehicle->user) {
                $vehicle->user->notify(new \App\Notifications\ScadenzaDocumentoVehicleNotification($vehicle, 0)); // 0 giorni rimanenti per i documenti già scaduti
                $adminUser = new User();
                $adminUser->email = 'amministrazione@coimaf.com';
                $adminUser->notify(new ScadenzaDocumentoVehicleNotification($vehicle, 0));
                // Mail::to('operativo@coimaf.com')->send(new \App\Notifications\ScadenzaDocumentoVehicleNotification($employee, 0));
                if ($vehicle->updatedBy) {
                    $vehicle->updatedBy->notify(new \App\Notifications\ScadenzaDocumentoVehicleNotification($vehicle, 0)); // 0 giorni rimanenti per i documenti già scaduti
                }
            }
        }
    }
    
    private function sendNotificationsForExpiringDocuments($days)
    {
        // Trova tutti gli impiegati con documenti che scadono entro $days giorni
        $vehicles = Vehicle::with('user', 'updatedBy')
        ->whereHas('documents', function ($query) use ($days) {
            $query->where('expiry_date', '=', now()->addDays($days)->format('Y-m-d'));
        })
        ->orWhereHas('maintenances', function ($subquery) {
            $subquery->where('end_at', '<', now()->format('Y-m-d'));
        })
        ->get();
        
        foreach ($vehicles as $vehicle) {
            if ($vehicle->user) {
                $vehicle->user->notify(new \App\Notifications\ScadenzaDocumentoVehicleNotification($vehicle, $days));
                
                 // Invia la notifica all'indirizzo di amministrazione fittizio
                 $adminUser = new User();
                 $adminUser->email = 'amministrazione@coimaf.com';
                 $adminUser->notify(new ScadenzaDocumentoVehicleNotification($vehicle, $days));

                // Mail::to('operativo@coimaf.com')->send(new \App\Notifications\ScadenzaDocumentoVehicleNotification($vehicle, $days));
                if ($vehicle->updatedBy) {
                    $vehicle->updatedBy->notify(new \App\Notifications\ScadenzaDocumentoVehicleNotification($vehicle, $days));
                }
            }
        }
    }
}
