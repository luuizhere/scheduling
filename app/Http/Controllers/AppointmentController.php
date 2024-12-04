<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function schedule(Company $company, Service $service)
    {
        $employees = $company->employees()
            ->with(['appointments' => function ($query) {
                $query->where('date', '>=', now());
            }])
            ->get();

        return view('appointments.schedule', compact('company', 'service', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'service_id' => 'required|exists:services,id',
            'start_time' => 'required|date|after:now',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $validated['end_time'] = Carbon::parse($validated['start_time'])
            ->addMinutes($service->duration);

        $validated['user_id'] = auth()->id();

        // Verificar disponibilidade
        $conflictingAppointments = Appointment::where('employee_id', $validated['employee_id'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
            })->exists();

        if ($conflictingAppointments) {
            return back()->withErrors(['message' => 'Horário indisponível']);
        }

        Appointment::create($validated);
        return redirect()->route('appointments.index');
    }
}
