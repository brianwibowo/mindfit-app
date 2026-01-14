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
            $payment->user->update([
                'is_premium' => true,
                'premium_until' => now()->addMonths($payment->duration_months),
            ]);
        } else {
            // Jika rejected/revision, pastikan premium dicabut (jika sebelumnya pxremium)
            // Atau biarkan saja.
        }

        return redirect()->back()->with('success', 'Status pembayaran diperbarui.');
    }
}
