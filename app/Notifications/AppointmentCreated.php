<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    use Queueable;

    public function __construct(public Appointment $appointment) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Agendamento Confirmado')
            ->line("Olá {$notifiable->name}!")
            ->line("Seu agendamento foi confirmado para {$this->appointment->start_time->format('d/m/Y H:i')}")
            ->line("Serviço: {$this->appointment->service->name}")
            ->line("Profissional: {$this->appointment->employee->user->name}")
            ->action('Ver Detalhes', route('appointments.show', $this->appointment));
    }

    public function toDatabase($notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'message' => "Novo agendamento confirmado para {$this->appointment->start_time->format('d/m/Y H:i')}"
        ];
    }
}
