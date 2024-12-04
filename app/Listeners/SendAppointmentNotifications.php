<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAppointmentNotifications
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AppointmentCreated $event): void
    {
        $appointment = $event->appointment;

        // Notifica cliente
        $appointment->user->notify(new AppointmentCreated($appointment));

        // Notifica funcionário
        $appointment->employee->user->notify(new AppointmentCreated($appointment));

        // Notifica gestor
        $manager = $appointment->employee->company->manager;
        $manager->notify(new AppointmentCreated($appointment));
    }
}
