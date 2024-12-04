<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'employee_id' => 'required|exists:employees,id',
            'service_id' => 'required|exists:services,id'
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $service = Service::findOrFail($request->service_id);
        $date = Carbon::parse($request->date);

        $workingHours = [
            'start' => '09:00',
            'end' => '18:00',
            'interval' => $service->duration
        ];

        $bookedSlots = Appointment::where('employee_id', $employee->id)
            ->whereDate('start_time', $date)
            ->get(['start_time', 'end_time'])
            ->map(function ($appointment) {
                return [
                    Carbon::parse($appointment->start_time),
                    Carbon::parse($appointment->end_time)
                ];
            });

        $availableSlots = [];
        $currentTime = Carbon::parse($date->format('Y-m-d') . ' ' . $workingHours['start']);
        $endTime = Carbon::parse($date->format('Y-m-d') . ' ' . $workingHours['end']);

        while ($currentTime->addMinutes($service->duration) <= $endTime) {
            $slotEnd = $currentTime->copy()->addMinutes($service->duration);

            $isAvailable = !$bookedSlots->contains(function ($bookedSlot) use ($currentTime, $slotEnd) {
                return $currentTime->between($bookedSlot[0], $bookedSlot[1]) ||
                       $slotEnd->between($bookedSlot[0], $bookedSlot[1]);
            });

            if ($isAvailable && $currentTime->greaterThan(now())) {
                $availableSlots[] = $currentTime->format('Y-m-d H:i:s');
            }

            $currentTime->addMinutes($workingHours['interval']);
        }

        return response()->json($availableSlots);
    }
}
