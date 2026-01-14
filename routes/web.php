<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Coach\CoachDashboardController;
use App\Http\Controllers\Client\ClientDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD UMUM (fallback)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| DASHBOARD BERDASARKAN ROLE
|--------------------------------------------------------------------------
| Middleware auth WAJIB
| Middleware role (opsional tapi direkomendasikan)
*/
Route::middleware(['auth'])->group(function () {

    // Jalur khusus Admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Client Management
        Route::get('/clients', [\App\Http\Controllers\Admin\AdminClientController::class, 'index'])->name('clients.index');

        // Coach Management
        Route::get('/coaches', [\App\Http\Controllers\Admin\AdminCoachController::class, 'index'])->name('coaches.index');
        Route::get('/coaches/create', [\App\Http\Controllers\Admin\AdminCoachController::class, 'create'])->name('coaches.create');
        Route::post('/coaches', [\App\Http\Controllers\Admin\AdminCoachController::class, 'store'])->name('coaches.store');

        Route::get('/coaches/{coach}', [\App\Http\Controllers\Admin\AdminCoachController::class, 'show'])->name('coaches.show');
        Route::post('/coaches/{coach}/assign-clients', [\App\Http\Controllers\Admin\AdminCoachController::class, 'assignClients'])->name('coaches.assign_clients');
        Route::delete('/coaches/{coach}/clients/{client}', [\App\Http\Controllers\Admin\AdminCoachController::class, 'unassignClient'])->name('coaches.unassign_client');

        Route::post('/coaches/assign', [\App\Http\Controllers\Admin\AdminCoachController::class, 'assign'])->name('coaches.assign'); // Old fallback if needed

        // Payment Management
        Route::patch('/payments/{payment}', [\App\Http\Controllers\Admin\AdminPaymentController::class, 'update'])->name('payments.update');

        // Package Management
        Route::resource('packages', \App\Http\Controllers\Admin\AdminPackageController::class);
        Route::get('/packages/{package}', [\App\Http\Controllers\Admin\AdminPackageController::class, 'show'])->name('packages.show');

        // Verification Flows
        Route::get('/verification/{id}', [\App\Http\Controllers\Admin\AdminVerificationController::class, 'show'])->name('verification.show');
        Route::post('/verification/{id}', [\App\Http\Controllers\Admin\AdminVerificationController::class, 'update'])->name('verification.update');
    });

    // Jalur khusus Coach
    Route::middleware(['role:coach'])->prefix('coach')->name('coach.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Coach\CoachDashboardController::class, 'index'])->name('dashboard');

        // Session Management
        Route::get('/sessions/create/{client}', [\App\Http\Controllers\Coach\CoachSessionController::class, 'create'])->name('sessions.create');
        Route::post('/sessions/{client}', [\App\Http\Controllers\Coach\CoachSessionController::class, 'store'])->name('sessions.store');

        // Monitoring
        Route::get('/clients/{client}/progress', [\App\Http\Controllers\Coach\CoachClientProgressController::class, 'show'])->name('clients.progress');
    });

    // Jalur khusus Client
    Route::middleware(['role:client'])->prefix('client')->name('client.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Client\ClientDashboardController::class, 'index'])->name('dashboard');
        Route::post('/payment', [\App\Http\Controllers\Client\ClientPaymentController::class, 'store'])->name('payment.store');

        // Service Routes
        Route::get('/sessions', [\App\Http\Controllers\Client\ClientSessionController::class, 'index'])->name('sessions.index');

        // Progress Routes
        Route::get('/progress', [\App\Http\Controllers\Client\ClientProgressController::class, 'index'])->name('progress.index');
        Route::get('/progress/create', [\App\Http\Controllers\Client\ClientProgressController::class, 'create'])->name('progress.create');
        Route::post('/progress', [\App\Http\Controllers\Client\ClientProgressController::class, 'store'])->name('progress.store');
    });

});

/*
|--------------------------------------------------------------------------
| PROFILE (Breeze Default)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
