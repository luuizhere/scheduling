<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $company = auth()->user()->role === 'manager'
            ? auth()->user()->managedCompanies()->first()
            : auth()->user()->employeeProfile->company;

        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        $metrics = [
            'appointments' => Appointment::where('company_id', $company->id)
                ->whereBetween('start_time', [$start, $end])
                ->count(),
            'revenue' => Appointment::where('company_id', $company->id)
                ->where('payment_status', 'paid')
                ->whereBetween('start_time', [$start, $end])
                ->sum('service_price'),
            'services' => Service::where('company_id', $company->id)->count(),
            'employees' => Employee::where('company_id', $company->id)->count()
        ];

        return view('dashboard.index', compact('metrics'));
    }

    public function reports()
    {
        $company = auth()->user()->managedCompanies()->first();

        $monthlyRevenue = Appointment::where('company_id', $company->id)
            ->where('payment_status', 'paid')
            ->whereBetween('start_time', [now()->startOfYear(), now()])
            ->selectRaw('MONTH(start_time) as month, SUM(service_price) as total')
            ->groupBy('month')
            ->get();

        $popularServices = Service::where('company_id', $company->id)
            ->withCount('appointments')
            ->orderBy('appointments_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.reports', compact('monthlyRevenue', 'popularServices'));
    }
}
