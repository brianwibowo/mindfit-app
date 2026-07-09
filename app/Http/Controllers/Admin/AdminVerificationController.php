<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminVerificationController extends Controller
{
    public function show($id)
    {
        $payment = Payment::with(['user.coaches', 'package'])->findOrFail($id);
        $coaches = \App\Models\User::where('role', 'coach')->get();
        return view('admin.verification.show', compact('payment', 'coaches'));
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $action = $request->input('action'); // approved, revision, rejected

        if ($action == 'approved') {
            $payment->update([
                'status' => 'approved',
                'subscription_start' => now(),
                'subscription_end' => now()->addDays($payment->package_data['package_duration'] ?? 30),
            ]);

            // Activate User
            $payment->user->update([
                'is_premium' => true,
                'premium_until' => now()->addDays($payment->package_data['package_duration'] ?? 30),
            ]);

            // Auto-assign PT if selected
            $packageData = $payment->package_data;
            if (isset($packageData['pt_id'])) {
                $ptId = $packageData['pt_id'];
                $ptCoach = \App\Models\User::find($ptId);
                if ($ptCoach) {
                    $payment->user->coaches()->detach($ptId);
                    $payment->user->coaches()->attach($ptId, ['type' => 'fitness']);
                }
            }

            // Auto-assign Nutritionist if selected
            if (isset($packageData['nutritionist_id'])) {
                $nutriId = $packageData['nutritionist_id'];
                $nutriCoach = \App\Models\User::find($nutriId);
                if ($nutriCoach) {
                    $payment->user->coaches()->detach($nutriId);
                    $payment->user->coaches()->attach($nutriId, ['type' => 'nutritionist']);
                }
            }

            return redirect()->route('admin.clients.index')->with('success', 'Pendaftaran Disetujui! Klien kini Aktif dan Coach otomatis ditugaskan.');

        } elseif ($action == 'revision') {
            $request->validate(['admin_note' => 'required|string']);

            $payment->update([
                'status' => 'revision',
                'admin_note' => $request->admin_note,
            ]);

            return redirect()->route('admin.clients.index')->with('success', 'Permintaan Revisi dikirim ke Klien.');

        } elseif ($action == 'rejected') {
            $payment->update(['status' => 'rejected']);
            return redirect()->route('admin.clients.index')->with('success', 'Pendaftaran Ditolak.');
        }

        return redirect()->back();
    }
}
