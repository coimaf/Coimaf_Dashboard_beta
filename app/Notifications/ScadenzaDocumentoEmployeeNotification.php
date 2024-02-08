<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ScadenzaDocumentoEmployeeNotification extends Notification
{
    use Queueable;
    
    protected $employee;
    protected $daysRemaining;
    
    /**
     * Create a new notification instance.
     *
     * @param Employee $employee
     * @param int $daysRemaining
     */
    public function __construct(Employee $employee, int $daysRemaining)
    {
        $this->employee = $employee;
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
        $documents = $this->employee->documents;
        $message = '';

        if ($documents->isNotEmpty()) {
            // Itera su tutti i documenti dell'impiegato
            foreach ($documents as $document) {
                $expiryDate = Carbon::parse($document->pivot->expiry_date);
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
            // Nessun documento trovato per l'impiegato
            $message = 'Nessun documento trovato per ' . $this->employee->name . ' ' . $this->employee->surname;
        }

        return (new MailMessage)
            ->subject('Scadenza documenti di ' . $this->employee->name . ' ' . $this->employee->surname)
            ->greeting('Scadenza documenti per ' . $this->employee->name . ' ' . $this->employee->surname)
            ->line($message)
            ->action('Visualizza profilo', route('dashboard.employees.show', $this->employee))
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
