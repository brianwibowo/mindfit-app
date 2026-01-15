<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoachingSession;
use Illuminate\Support\Facades\Auth;
use App\Models\Package;

class ClientDashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Get Payment History (All)
        $payments = $user->payments()->latest()->get();

        // 2. Active Package Count
        $activePackages = $user->payments()
            ->where('status', 'approved')
            ->where('subscription_end', '>=', now())
            ->count();

        // 3. Total Spent
        $totalSpent = $user->payments()
            ->where('status', 'approved')
            ->get()
            ->sum(function ($p) {
                return $p->package_data['total_price'] ?? 0;
            });

        // 4. Get Next Session
        $nextSession = CoachingSession::where('client_id', Auth::id())
            ->where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->first();

        return view('client.dashboard', compact('payments', 'activePackages', 'totalSpent', 'nextSession'));
    }
}