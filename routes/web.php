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
    $role = auth()->user()->role;
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'coach') {
        return redirect()->route('coach.dashboard');
    } elseif ($role === 'client') {
        return redirect()->route('client.dashboard');
    }
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

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
        Route::get('/clients/create', [\App\Http\Controllers\Admin\AdminClientController::class, 'create'])->name('clients.create');
        Route::post('/clients', [\App\Http\Controllers\Admin\AdminClientController::class, 'store'])->name('clients.store');

        // Coach Management
        Route::get('/coaches', [\App\Http\Controllers\Admin\AdminCoachController::class, 'index'])->name('coaches.index');
        Route::get('/coaches/create', [\App\Http\Controllers\Admin\AdminCoachController::class, 'create'])->name('coaches.create');
        Route::post('/coaches', [\App\Http\Controllers\Admin\AdminCoachController::class, 'store'])->name('coaches.store');
        Route::get('/coaches/{coach}/edit', [\App\Http\Controllers\Admin\AdminCoachController::class, 'edit'])->name('coaches.edit');
        Route::put('/coaches/{coach}', [\App\Http\Controllers\Admin\AdminCoachController::class, 'update'])->name('coaches.update');

        Route::get('/coaches/{coach}', [\App\Http\Controllers\Admin\AdminCoachController::class, 'show'])->name('coaches.show');
        Route::delete('/coaches/{coach}', [\App\Http\Controllers\Admin\AdminCoachController::class, 'destroy'])->name('coaches.destroy');
        Route::post('/coaches/{coach}/assign-clients', [\App\Http\Controllers\Admin\AdminCoachController::class, 'assignClients'])->name('coaches.assign_clients');
        Route::delete('/coaches/{coach}/clients/{client}', [\App\Http\Controllers\Admin\AdminCoachController::class, 'unassignClient'])->name('coaches.unassign_client');

        // Admin User Management
        Route::get('/admins', [\App\Http\Controllers\Admin\AdminAdminController::class, 'index'])->name('admins.index');
        Route::get('/admins/create', [\App\Http\Controllers\Admin\AdminAdminController::class, 'create'])->name('admins.create');
        Route::post('/admins', [\App\Http\Controllers\Admin\AdminAdminController::class, 'store'])->name('admins.store');
        Route::delete('/admins/{admin}', [\App\Http\Controllers\Admin\AdminAdminController::class, 'destroy'])->name('admins.destroy');

        Route::post('/coaches/assign', [\App\Http\Controllers\Admin\AdminCoachController::class, 'assign'])->name('coaches.assign'); // Old fallback if needed

        // Payment Management
        Route::patch('/payments/{payment}', [\App\Http\Controllers\Admin\AdminPaymentController::class, 'update'])->name('payments.update');

        // Package Management
        Route::resource('packages', \App\Http\Controllers\Admin\AdminPackageController::class);
        Route::get('/packages/{package}', [\App\Http\Controllers\Admin\AdminPackageController::class, 'show'])->name('packages.show');


        Route::resource('sessions', \App\Http\Controllers\Admin\AdminSessionController::class);
        Route::patch('/sessions/{session}/status', [\App\Http\Controllers\Admin\AdminSessionController::class, 'updateStatus'])->name('sessions.update_status');
        Route::get('/monitor-progress/{id}/pdf', [\App\Http\Controllers\Admin\AdminProgressController::class, 'downloadPdf'])->name('progress.pdf');
        Route::get('/monitor-progress/client/{clientId}', [\App\Http\Controllers\Admin\AdminProgressController::class, 'clientTimeline'])->name('progress.client_timeline');
        Route::resource('monitor-progress', \App\Http\Controllers\Admin\AdminProgressController::class)
            ->only(['index', 'show'])
            ->names('progress');

        // Monitoring AI Analysis
        Route::get('/monitoring/ai', [\App\Http\Controllers\Admin\AdminAIController::class, 'index'])->name('ai.index');
        Route::get('/monitoring/ai/create', [\App\Http\Controllers\Admin\AdminAIController::class, 'create'])->name('ai.create');
        Route::post('/monitoring/ai', [\App\Http\Controllers\Admin\AdminAIController::class, 'store'])->name('ai.store');
        Route::get('/monitoring/ai/{id}', [\App\Http\Controllers\Admin\AdminAIController::class, 'show'])->name('ai.show');

        // Verification Flows
        Route::get('/verification/{id}', [\App\Http\Controllers\Admin\AdminVerificationController::class, 'show'])->name('verification.show');
        Route::post('/verification/{id}', [\App\Http\Controllers\Admin\AdminVerificationController::class, 'update'])->name('verification.update');

        // Finance Management
        Route::get('/finance', [\App\Http\Controllers\Admin\AdminFinanceController::class, 'index'])->name('finance.index');
        Route::get('/finance/export-pdf', [\App\Http\Controllers\Admin\AdminFinanceController::class, 'exportPdf'])->name('finance.export_pdf');
        Route::get('/finance/export-excel', [\App\Http\Controllers\Admin\AdminFinanceController::class, 'exportExcel'])->name('finance.export_excel');
        Route::post('/finance/expenses', [\App\Http\Controllers\Admin\AdminFinanceController::class, 'storeExpense'])->name('finance.expenses.store');
        Route::put('/finance/expenses/{expense}', [\App\Http\Controllers\Admin\AdminFinanceController::class, 'updateExpense'])->name('finance.expenses.update');
        Route::delete('/finance/expenses/{expense}', [\App\Http\Controllers\Admin\AdminFinanceController::class, 'destroyExpense'])->name('finance.expenses.destroy');

        // Discount Management
        Route::resource('discounts', \App\Http\Controllers\Admin\AdminDiscountController::class);
    });

    // Jalur khusus Coach
    Route::middleware(['role:coach'])->prefix('coach')->name('coach.')->group(function () {
        Route::get('/dashboard', [CoachDashboardController::class, 'index'])->name('dashboard');

        // Session Management
        Route::get('/sessions', [\App\Http\Controllers\Coach\CoachSessionController::class, 'index'])->name('sessions.index');
        Route::get('/sessions/create/{client?}', [\App\Http\Controllers\Coach\CoachSessionController::class, 'create'])->name('sessions.create');
        Route::post('/sessions', [\App\Http\Controllers\Coach\CoachSessionController::class, 'store'])->name('sessions.store');
        Route::get('/sessions/{session}', [\App\Http\Controllers\Coach\CoachSessionController::class, 'show'])->name('sessions.show');
        Route::get('/sessions/{session}/edit', [\App\Http\Controllers\Coach\CoachSessionController::class, 'edit'])->name('sessions.edit');
        Route::put('/sessions/{session}', [\App\Http\Controllers\Coach\CoachSessionController::class, 'update'])->name('sessions.update');
        Route::delete('/sessions/{session}', [\App\Http\Controllers\Coach\CoachSessionController::class, 'destroy'])->name('sessions.destroy');

        // Monitoring
        Route::get('/progress', [\App\Http\Controllers\Coach\CoachClientProgressController::class, 'index'])->name('progress.index');
        Route::get('/progress/{id}/pdf', [\App\Http\Controllers\Coach\CoachClientProgressController::class, 'downloadPdf'])->name('progress.pdf');
        Route::get('/progress/{id}', [\App\Http\Controllers\Coach\CoachClientProgressController::class, 'show'])->name('progress.show');
        Route::put('/progress/{id}', [\App\Http\Controllers\Coach\CoachClientProgressController::class, 'update'])->name('progress.update');
    });

    // Jalur khusus Client
    Route::middleware(['role:client'])->prefix('client')->name('client.')->group(function () {
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');

        // Registration / Payment Flow
        Route::get('/register-package', [\App\Http\Controllers\Client\ClientPaymentController::class, 'create'])->name('payment.create');
        Route::post('/payment', [\App\Http\Controllers\Client\ClientPaymentController::class, 'store'])->name('payment.store');
        Route::get('/payment/{payment}', [\App\Http\Controllers\Client\ClientPaymentController::class, 'show'])->name('payment.show');
        Route::get('/payment/{payment}/edit', [\App\Http\Controllers\Client\ClientPaymentController::class, 'edit'])->name('payment.edit');
        Route::patch('/payment/{payment}', [\App\Http\Controllers\Client\ClientPaymentController::class, 'update'])->name('payment.update');
        Route::post('/discount/validate', [\App\Http\Controllers\Client\ClientPaymentController::class, 'validateDiscount'])->middleware('throttle:10,1')->name('discount.validate');

        // Service Routes
        Route::get('/sessions', [\App\Http\Controllers\Client\ClientSessionController::class, 'index'])->name('sessions.index');
        Route::get('/sessions/{session}', [\App\Http\Controllers\Client\ClientSessionController::class, 'show'])->name('sessions.show');

        // Progress Routes
        Route::get('/progress', [\App\Http\Controllers\Client\ClientProgressController::class, 'index'])->name('progress.index');
        Route::get('/progress/visuals', [\App\Http\Controllers\Client\ClientProgressController::class, 'charts'])->name('progress.charts');
        Route::get('/progress/create', [\App\Http\Controllers\Client\ClientProgressController::class, 'create'])->name('progress.create');
        Route::post('/progress', [\App\Http\Controllers\Client\ClientProgressController::class, 'store'])->name('progress.store');
        Route::get('/progress/{id}/pdf', [\App\Http\Controllers\Client\ClientProgressController::class, 'downloadPdf'])->name('progress.pdf');
        Route::get('/progress/{id}', [\App\Http\Controllers\Client\ClientProgressController::class, 'show'])->name('progress.show');
        Route::get('/progress/{id}/edit', [\App\Http\Controllers\Client\ClientProgressController::class, 'edit'])->name('progress.edit');
        Route::put('/progress/{id}', [\App\Http\Controllers\Client\ClientProgressController::class, 'update'])->name('progress.update');
        Route::delete('/progress/{id}', [\App\Http\Controllers\Client\ClientProgressController::class, 'destroy'])->name('progress.destroy');

        // AI Feature
        Route::get('/ai', [\App\Http\Controllers\Client\ClientAIController::class, 'index'])->name('ai.index');
        Route::post('/ai/analyze', [\App\Http\Controllers\Client\ClientAIController::class, 'analyze'])->name('ai.analyze');
        Route::get('/ai/history', [\App\Http\Controllers\Client\ClientAIController::class, 'history'])->name('ai.history');
        Route::get('/ai/history/{id}', [\App\Http\Controllers\Client\ClientAIController::class, 'show'])->name('ai.show');
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
| STORAGE FALLBACK ROUTE (FOR SHARED HOSTING / CPANEL)
|--------------------------------------------------------------------------
*/
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    return response()->file($filePath);
})->where('path', '.*');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
