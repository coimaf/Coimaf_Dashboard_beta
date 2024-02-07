<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Models\Deadline;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ScadenzaScadutaNotification extends Notification
{
    use Queueable;
    
    protected $deadline;
    protected $daysRemaining;
    
    /**
    * Create a new notification instance.
    */
    public function __construct(Deadline $deadline, int $daysRemaining)
    {
        $this->deadline = $deadline;
        $this->daysRemaining = $daysRemaining;
    }
    
    /**
    * Get the notification's delivery channels.
    *
    * @return array<int, string>
    */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }
    
    /**
    * Get the mail representation of the notification.
    */
    public function toMail(object $notifiable): MailMessage
    {
        $expiryDate = Carbon::parse($this->deadline->documentDeadlines->first()->expiry_date);
        $expiryDateString = $expiryDate->format('d-m-Y');
        $daysRemaining = now()->diff($expiryDate)->days;
        
        // Costruisci il messaggio in base ai giorni rimanenti
        if ($daysRemaining == 0) {
            $message = 'Il Documento è scaduto il: ' . $expiryDateString;
        } elseif ($daysRemaining <= 7) {
            $message = 'Mancano solo 7 giorni alla scadenza: ' . $expiryDateString;
        } elseif ($daysRemaining <= 30) {
            $message = 'Mancano solo 30 giorni alla scadenza: ' . $expiryDateString;
        } elseif ($daysRemaining <= 60) {
            $message = 'Mancano solo 60 giorni alla scadenza: ' . $expiryDateString;
        } else {
            $message = 'Il Documento è scaduto il: ' . $expiryDateString;
        }
        
        
        return (new MailMessage)
        ->subject('Documento scaduto: ' . $this->deadline->name)
        ->greeting('Nome della scadenza: ' . $this->deadline->name)
        ->line($message)
        ->action('Visualizza scadenza', route('dashboard.deadlines.show', $this->deadline))
        ->salutation("Saluti,\n" . config('app.name'));
    }
    
    /**
    * Get the array representation of the notification.
    *
    * @return array<string, mixed>
    */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
