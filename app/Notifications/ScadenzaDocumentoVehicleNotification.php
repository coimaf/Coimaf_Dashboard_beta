<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ScadenzaDocumentoVehicleNotification extends Notification
{
    use Queueable;
    
    protected $vehicle;
    protected $daysRemaining;
    
    /**
    * Create a new notification instance.
    *
    * @param Vehicle $vehicle
    * @param int $daysRemaining
    */
    public function __construct(Vehicle $vehicle, int $daysRemaining)
    {
        $this->vehicle = $vehicle;
        $this->daysRemaining = $daysRemaining;
    }
    
    /**
    * Get the notification's delivery channels.
    *
    * @param  mixed  $notifiable
    * @return array
    */
    public function via($notifiable)
    {
        return ['mail'];
    }
    
    /**
    * Get the mail representation of the notification.
    *
    * @param  mixed  $notifiable
    * @return \Illuminate\Notifications\Messages\MailMessage
    */
    public function toMail($notifiable)
    {
        $documents = $this->vehicle->documents()->get(); // Ottenere i documenti tramite la relazione
        $maintenances = $this->vehicle->maintenances()->get();
        // Rimuovi dd($documents) poiché interrompe l'esecuzione del codice
        
        $message = '';
        
        if ($documents->isNotEmpty()) {
            // Itera su tutti i documenti 
            foreach ($documents as $document) {
                $expiryDate = Carbon::parse($document->expiry_date);
                $expiryDateString = $expiryDate->format('d-m-Y');
                
                // Calcola i giorni rimanenti fino alla scadenza del documento
                $daysRemaining = now()->diffInDays($expiryDate, false) + 1;
                
                // Costruisci il messaggio in base ai giorni rimanenti
                if ($daysRemaining <= 0) {
                    $message .= $document->name . ' scaduto il ' . $expiryDateString;
                } else {
                    $message .= 'Mancano solo ' . $daysRemaining . ' giorni alla scadenza di: ' .  $document->name . ' ' . $expiryDateString;
                }
                
                $message .= " "; // Aggiungi una nuova riga dopo ogni documento
            }
        } else {
            // Nessun documento trovato
            $message = 'Nessun documento trovato per ' . $this->vehicle->name . ' ' . $this->vehicle->surname;
        }

        if ($maintenances->isNotEmpty()) {
            // Itera su tutti i maintenancei 
            foreach ($maintenances as $maintenance) {
                $expiryDate = Carbon::parse($maintenance->end_at);
                $expiryDateString = $expiryDate->format('d-m-Y');
                
                // Calcola i giorni rimanenti fino alla scadenza del maintenanceo
                $daysRemaining = now()->diffInDays($expiryDate, false) + 1;
                
                // Costruisci il messaggio in base ai giorni rimanenti
                if ($daysRemaining <= 0) {
                    $message .= $maintenance->name . ' scaduto il ' . $expiryDateString;
                } else {
                    $message .= 'Mancano solo ' . $daysRemaining . ' giorni alla scadenza di: ' .  $maintenance->name . ' ' . $expiryDateString;
                }
                
                $message .= " "; // Aggiungi una nuova riga dopo ogni documento
            }
        } else {
            // Nessun documento trovato
            $message = 'Nessun documento trovato per ' . $this->vehicle->name . ' ' . $this->vehicle->surname;
        }
        
        
        return (new MailMessage)
        ->subject('Scadenza documenti di ' . $this->vehicle->brand . ' ' . $this->vehicle->model . ' ' . 'con targa' . ' ' . $this->vehicle->license_plate)
        ->greeting('Scadenza documenti per ' . $this->vehicle->brand . ' ' . $this->vehicle->model . ' ' . 'con targa' . ' ' . $this->vehicle->license_plate)
        ->line($message)
        ->action('Visualizza profilo', route('dashboard.vehicles.show', $this->vehicle))
        ->salutation("Saluti,\n" . config('app.name'));
    }
    
    /**
    * Get the array representation of the notification.
    *
    * @param  mixed  $notifiable
    * @return array
    */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
