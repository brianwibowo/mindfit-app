<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $status = request('status', 'pending');
        $chartFilter = request('chart_filter', 'week'); // week, month, year

        // 1. Stats
        $totalMembers = User::where('role', 'client')->count();
        $verificationNeeded = Payment::where('status', 'pending')->count();
        $activeClients = User::where('role', 'client')->where('is_premium', true)->count();
        
        // Calculate Total Earnings (Approved Payments)
        $approvedPayments = Payment::where('status', 'approved')->get();
        $totalRevenue = 0;
        foreach ($approvedPayments as $p) {
            $totalRevenue += $p->package_data['total_price'] ?? $p->package_data['package_price'] ?? 0;
        }

        // 2. Trend Chart Data (Registrations)
        $dates = collect();
        $registrations = collect();

        if ($chartFilter == 'month') {
            // Daily for current month
            $daysInMonth = Carbon::now()->daysInMonth;
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $date = Carbon::createFromDate(null, null, $i);
                $dates->push($date->format('d'));
                $registrations->push(User::where('role', 'client')->whereDate('created_at', $date)->count());
            }
        } elseif ($chartFilter == 'year') {
            // Monthly for current year
            for ($i = 1; $i <= 12; $i++) {
                $date = Carbon::createFromDate(null, $i, 1);
                $dates->push($date->format('M'));
                $registrations->push(User::where('role', 'client')->whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->count());
            }
        } else {
            // Default: Week (Last 7 Days)
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $dates->push($date->format('d M'));
                $registrations->push(User::where('role', 'client')->whereDate('created_at', $date)->count());
            }
        }

        // 3. Recent Transactions (Last 5)
        $recentTransactions = Payment::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 4. Package Distribution for Doughnut Chart
        $packageCounts = [];
        foreach ($approvedPayments as $p) {
            $name = $p->package_data['package_name'] ?? ($p->package->name ?? 'Kustom / Lainnya');
            // Clean up name if too long
            if (strlen($name) > 30) {
                $name = substr($name, 0, 27) . '...';
            }
            if (!isset($packageCounts[$name])) {
                $packageCounts[$name] = 0;
            }
            $packageCounts[$name]++;
        }

        $packageLabels = array_keys($packageCounts);
        $packageValues = array_values($packageCounts);

        $now = Carbon::now();

        if ($chartFilter === 'month') {
            $chartTitle = 'Tren Pendaftaran Bulan ' . $now->translatedFormat('F Y');
        } elseif ($chartFilter === 'year') {
            $chartTitle = 'Tren Pendaftaran Tahun ' . $now->format('Y');
        } else {
            $chartTitle = 'Tren Pendaftaran Minggu Ini (7 Hari Terakhir)';
        }

        return view('admin.dashboard', compact(
            'totalMembers',
            'verificationNeeded',
            'activeClients',
            'totalRevenue',
            'dates',
            'registrations',
            'recentTransactions',
            'packageLabels',
            'packageValues',
            'chartFilter',
            'chartTitle'
        ));
    }
}
