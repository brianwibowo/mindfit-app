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

            // Auto-assign PT if selected
            if (isset($packageData['pt_id'])) {
                $ptId = $packageData['pt_id'];
                $ptCoach = User::find($ptId);
                if ($ptCoach) {
                    $payment->user->coaches()->detach($ptId);
                    $payment->user->coaches()->attach($ptId, ['type' => 'fitness']);
                }
            }

            // Auto-assign Nutritionist if selected
            if (isset($packageData['nutritionist_id'])) {
                $nutriId = $packageData['nutritionist_id'];
                $nutriCoach = User::find($nutriId);
                if ($nutriCoach) {
                    $payment->user->coaches()->detach($nutriId);
                    $payment->user->coaches()->attach($nutriId, ['type' => 'nutritionist']);
                }
            }
        } else {
            // Jika rejected/revision, pastikan premium dicabut (jika sebelumnya premium)
            // Atau biarkan saja.
        }

        return redirect()->back()->with('success', 'Status pembayaran diperbarui.');
    }
}
