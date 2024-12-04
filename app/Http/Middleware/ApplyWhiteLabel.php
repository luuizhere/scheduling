<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplyWhiteLabel
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && !request()->is('admin/*')) {
            $company = $this->getCompany();
            if ($company) {
                View::share('whitelabel', [
                    'name' => $company->name,
                    'logo' => $company->logo,
                    'colors' => [
                        'primary' => $company->primary_color,
                        'secondary' => $company->secondary_color
                    ]
                ]);
            }
        }
        return $next($request);
    }

    private function getCompany()
    {
        $user = auth()->user();
        if ($user->role === 'manager') {
            return $user->managedCompanies()->first();
        } elseif ($user->role === 'employee') {
            return $user->employeeProfile->company;
        }
        return null;
    }
}
