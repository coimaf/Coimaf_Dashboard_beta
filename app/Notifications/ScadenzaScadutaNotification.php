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

    /**
     * Create a new notification instance.
     */
    public function __construct(Deadline $deadline)
    {
        $this->deadline = $deadline;
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
        return (new MailMessage)
            ->subject('Documento scaduto: ' . $this->deadline->name)
            ->greeting('Nome della scadenza: ' . $this->deadline->name)
            ->line('Data di scadenza: ' . Carbon::parse($this->deadline->documentDeadlines->first()->expiry_date)->format('d-m-Y'))
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
