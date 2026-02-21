<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,revision',
        ]);

        $payment->update([
            'status' => $request->status,
        ]);

        // Jika approved, update user jadi premium
        if ($request->status == 'approved') {
            // Gunakan durasi hari dari snapshot paket jika ada, fallback ke bulan * 30
            $packageData = $payment->package_data;
            $durationDays = isset($packageData['package_duration'])
                ? $packageData['package_duration']
                : round($payment->duration_months * 30);

            $payment->user->update([
                'is_premium' => true,
                'premium_until' => now()->addDays($durationDays),
            ]);
        } else {
            // Jika rejected/revision, pastikan premium dicabut (jika sebelumnya pxremium)
            // Atau biarkan saja.
        }

        return redirect()->back()->with('success', 'Status pembayaran diperbarui.');
    }
}
