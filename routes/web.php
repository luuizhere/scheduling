<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


// routes/web.php
Route::middleware(['auth'])->group(function () {
    // Rotas Admin
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::resource('companies', AdminCompanyController::class);
        Route::resource('users', AdminUserController::class);
    });

    // Rotas Gestor
    Route::middleware(['role:manager'])->prefix('manager')->group(function () {
        Route::resource('company', ManagerCompanyController::class);
        Route::resource('employees', ManagerEmployeeController::class);
        Route::resource('services', ManagerServiceController::class);
    });

    // Rotas Funcionário
    Route::middleware(['role:employee'])->prefix('employee')->group(function () {
        Route::get('/appointments', [EmployeeAppointmentController::class, 'index']);
        Route::patch('/appointments/{appointment}/status', [EmployeeAppointmentController::class, 'updateStatus']);
    });

    // Rotas Cliente
    Route::middleware(['role:customer'])->prefix('appointments')->group(function () {
        Route::get('/', [AppointmentController::class, 'index']);
        Route::post('/', [AppointmentController::class, 'store']);
        Route::get('/schedule/{company}/{service}', [AppointmentController::class, 'schedule']);
    });
});

// routes/web.php
Route::post('webhooks/stripe', [PaymentController::class, 'handleWebhook']);

require __DIR__.'/auth.php';
