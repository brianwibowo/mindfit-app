<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientPaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'address' => 'required|string',
            'package_id' => 'required|exists:packages,id',
            'proof_file' => 'required|image|max:5048',
        ]);

        $user = Auth::user();

        // 1. Update User Profile
        $user->update([
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // 2. Prepare Snapshot Data
        $package = \App\Models\Package::find($request->package_id);
        $hasMealPlan = $request->has('meal_plan');
        $mealPlanPrice = 400000;

        $snapshot = [
            'package_name' => $package->name,
            'package_price' => $package->price,
            'package_duration' => $package->duration_days,
            'addon_meal_plan' => $hasMealPlan,
            'addon_price' => $hasMealPlan ? $mealPlanPrice : 0,
            'total_price' => $package->price + ($hasMealPlan ? $mealPlanPrice : 0),
        ];

        // 3. Store Payment
        $path = $request->file('proof_file')->store('payments', 'public');

        // Check if there is an existing pending/revision payment to update, or create new
        // For simplicity, we create new or update the latest if it was revision.
        // But requirements say "After corrected, status becomes Pending".

        $payment = Payment::updateOrCreate(
            ['user_id' => $user->id, 'status' => 'revision'], // Try to find revision one
            [
                'user_id' => $user->id,
                'package_id' => $package->id,
                'package_data' => $snapshot,
                'proof_file' => $path,
                'status' => 'pending', // Set back to pending
                // duration_months is legacy, we rely on snapshot duration now
                'duration_months' => round($package->duration_days / 30),
                'admin_note' => null, // Clear revision note
            ]
        );

        // If updateOrCreate didn't find 'revision', it created a new one. 
        // But we might want to check if there was a 'rejected' one? 
        // Allow multiple records history. If updateOrCreate created a NEW one (wasn't revision), good.
        // If it updated Revision, also good.

        return redirect()->back()->with('success', 'Pendaftaran berhasil dikirim! Mohon tunggu verifikasi admin.');
    }
}
