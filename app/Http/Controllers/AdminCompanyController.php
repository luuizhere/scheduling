<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCompanyController extends Controller
{
    public function index()
    {
        $companies = Company::with('employees')->paginate(10);
        return view('admin.companies.index', compact('companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:1024',
            'primary_color' => 'required|string|max:7',
            'secondary_color' => 'required|string|max:7',
            'payment_required' => 'boolean'
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Company::create($validated);
        return redirect()->route('admin.companies.index');
    }
}
