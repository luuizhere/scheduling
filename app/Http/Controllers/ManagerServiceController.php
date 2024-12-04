<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerServiceController extends Controller
{
    public function index()
    {
        $company = auth()->user()->managedCompanies()->firstOrFail();
        $services = $company->services()->paginate(10);
        return view('manager.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $company = auth()->user()->managedCompanies()->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $company->services()->create($validated);
        return redirect()->route('manager.services.index');
    }
}
