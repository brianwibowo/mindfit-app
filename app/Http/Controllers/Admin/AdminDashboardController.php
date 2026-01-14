<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $status = request('status', 'pending');

        // 1. Stats
        $totalMembers = User::where('role', 'client')->count();
        $verificationNeeded = Payment::where('status', 'pending')->count();
        $activeClients = User::where('role', 'client')->where('is_premium', true)->count();
        $totalCoaches = User::where('role', 'coach')->count();

        // 2. Trend Chart (7 Days)
        $dates = collect();
        $registrations = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::today()->subDays($i);
            $dates->push($date->format('d M'));
            $registrations->push(User::where('role', 'client')->whereDate('created_at', $date)->count());
        }

        // 3. Stats
        // Data charts passed via compact

        return view('admin.dashboard', compact(
            'totalMembers',
            'verificationNeeded',
            'activeClients',
            'totalCoaches',
            'dates',
            'registrations'
        ));
    }
}