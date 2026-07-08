<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientPaymentController extends Controller
{
    public function create()
    {
        $packages = \App\Models\Package::where('is_active', true)->get();
        $coaches = \App\Models\User::where('role', 'coach')->where('is_active', true)->with('coachProfile')->get();
        return view('client.register', compact('packages', 'coaches'));
    }

    public function show(Payment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }
        return view('client.payment.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }
        if ($payment->status != 'revision') {
            return redirect()->route('client.dashboard')->with('error', 'Hanya status Revisi yang dapat diedit.');
        }

        $packages = \App\Models\Package::where('is_active', true)->get();
        $coaches = \App\Models\User::where('role', 'coach')->where('is_active', true)->with('coachProfile')->get();
        $user = Auth::user()->fresh();
        return view('client.payment.edit', compact('payment', 'packages', 'user', 'coaches'));
    }

    public function update(Request $request, Payment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'phone' => 'required|string|regex:/^08[0-9]{8,13}$/',
            'address' => 'required|string',
            'package_ids' => 'required|array',
            'package_ids.*' => 'exists:packages,id',
            'proof_file' => 'nullable|file|mimes:jpeg,jpg,png,pdf,heic,heif|max:5120', // Optional for update, allows PDF
            'selected_pt_id' => 'required|exists:users,id',
            'selected_nutritionist_id' => 'nullable|exists:users,id',
            'discount_code' => 'nullable|string',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Update User Profile
        $user->update([
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // 2. Prepare Snapshot Data
        $packageIds = $request->package_ids;
        $packages = \App\Models\Package::whereIn('id', $packageIds)->get();
        $primaryPackage = $packages->first();

        $packageNames = [];
        $totalPackagePrice = 0;
        $maxDuration = 0;
        foreach ($packages as $pkg) {
            $packageNames[] = str_replace(['[Private] ', '[Group] ', '[Academy] ', '[Nutrition] '], '', $pkg->name);
            $totalPackagePrice += $pkg->price;
            if ($pkg->duration_days > $maxDuration) {
                $maxDuration = $pkg->duration_days;
            }
        }
        $packageName = implode(' + ', $packageNames);

        $discountPercent = 0;
        $discountValue = 0;
        $discountType = 'percent';
        $discountCode = $request->discount_code ? strtoupper(trim($request->discount_code)) : null;
        
        if ($discountCode) {
            $discount = \App\Models\Discount::where('code', $discountCode)->first();
            if ($discount && $discount->is_active) {
                $discountType = $discount->type;
                $discountValue = $discount->value;
            } else {
                if ($discountCode === "MINDFIT10") $discountPercent = 10;
                elseif ($discountCode === "MINDFIT20") $discountPercent = 20;
                elseif ($discountCode === "PROMO50") $discountPercent = 50;
            }
        }

        if ($discountPercent > 0) {
            $discountAmount = round($totalPackagePrice * ($discountPercent / 100));
        } else {
            if ($discountType === 'percent') {
                $discountAmount = round($totalPackagePrice * ($discountValue / 100));
                $discountPercent = $discountValue;
            } else { // nominal
                $discountAmount = $discountValue;
                if ($discountAmount > $totalPackagePrice) {
                    $discountAmount = $totalPackagePrice;
                }
                $discountPercent = round(($discountAmount / $totalPackagePrice) * 100);
            }
        }

        if (isset($discount) && $discount && $discount->max_limit && $discountAmount > $discount->max_limit) {
            $discountAmount = $discount->max_limit;
        }

        $totalPrice = $totalPackagePrice - $discountAmount;

        $snapshot = [
            'package_name' => $packageName,
            'package_price' => $totalPackagePrice,
            'package_duration' => $maxDuration,
            'package_ids' => $packageIds,
            'addon_meal_plan' => false,
            'addon_price' => 0,
            'discount_code' => $discountCode,
            'discount_percent' => $discountPercent,
            'discount_amount' => $discountAmount,
            'total_price' => $totalPrice,
            'pt_id' => $request->selected_pt_id,
            'nutritionist_id' => $request->selected_nutritionist_id,
        ];

        // 3. Update Payment
        $updateData = [
            'package_id' => $primaryPackage->id,
            'package_data' => $snapshot,
            'status' => 'pending', // Reset status to pending
            'admin_note' => null,   // Clear revision note
            'duration_months' => round($maxDuration / 30),
        ];

        if ($request->hasFile('proof_file')) {
            $path = $request->file('proof_file')->store('payments', 'public');
            $updateData['proof_file'] = $path;
        }

        $payment->update($updateData);

        return redirect()->route('client.dashboard')->with('success', 'Perbaikan berhasil dikirim! Mohon tunggu verifikasi admin.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|regex:/^08[0-9]{8,13}$/',
            'address' => 'required|string',
            'package_ids' => 'required|array',
            'package_ids.*' => 'exists:packages,id',
            'proof_file' => 'required|file|mimes:jpeg,jpg,png,pdf,heic,heif|max:5120', // Allows PDF, max 5MB
            'selected_pt_id' => 'required|exists:users,id',
            'selected_nutritionist_id' => 'nullable|exists:users,id',
            'discount_code' => 'nullable|string',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Update User Profile
        $user->update([
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // 2. Prepare Snapshot Data
        $packageIds = $request->package_ids;
        $packages = \App\Models\Package::whereIn('id', $packageIds)->get();
        $primaryPackage = $packages->first();

        $packageNames = [];
        $totalPackagePrice = 0;
        $maxDuration = 0;
        foreach ($packages as $pkg) {
            $packageNames[] = str_replace(['[Private] ', '[Group] ', '[Academy] ', '[Nutrition] '], '', $pkg->name);
            $totalPackagePrice += $pkg->price;
            if ($pkg->duration_days > $maxDuration) {
                $maxDuration = $pkg->duration_days;
            }
        }
        $packageName = implode(' + ', $packageNames);

        $discountPercent = 0;
        $discountValue = 0;
        $discountType = 'percent';
        $discountCode = $request->discount_code ? strtoupper(trim($request->discount_code)) : null;
        
        if ($discountCode) {
            $discount = \App\Models\Discount::where('code', $discountCode)->first();
            if ($discount && $discount->is_active) {
                $discountType = $discount->type;
                $discountValue = $discount->value;
            } else {
                if ($discountCode === "MINDFIT10") $discountPercent = 10;
                elseif ($discountCode === "MINDFIT20") $discountPercent = 20;
                elseif ($discountCode === "PROMO50") $discountPercent = 50;
            }
        }

        if ($discountPercent > 0) {
            $discountAmount = round($totalPackagePrice * ($discountPercent / 100));
        } else {
            if ($discountType === 'percent') {
                $discountAmount = round($totalPackagePrice * ($discountValue / 100));
                $discountPercent = $discountValue;
            } else { // nominal
                $discountAmount = $discountValue;
                if ($discountAmount > $totalPackagePrice) {
                    $discountAmount = $totalPackagePrice;
                }
                $discountPercent = round(($discountAmount / $totalPackagePrice) * 100);
            }
        }

        if (isset($discount) && $discount && $discount->max_limit && $discountAmount > $discount->max_limit) {
            $discountAmount = $discount->max_limit;
        }

        $totalPrice = $totalPackagePrice - $discountAmount;

        $snapshot = [
            'package_name' => $packageName,
            'package_price' => $totalPackagePrice,
            'package_duration' => $maxDuration,
            'package_ids' => $packageIds,
            'addon_meal_plan' => false,
            'addon_price' => 0,
            'discount_code' => $discountCode,
            'discount_percent' => $discountPercent,
            'discount_amount' => $discountAmount,
            'total_price' => $totalPrice,
            'pt_id' => $request->selected_pt_id,
            'nutritionist_id' => $request->selected_nutritionist_id,
        ];

        // 3. Store Payment
        $path = $request->file('proof_file')->store('payments', 'public');

        $payment = Payment::updateOrCreate(
            ['user_id' => $user->id, 'status' => 'revision'],
            [
                'user_id' => $user->id,
                'package_id' => $primaryPackage->id,
                'package_data' => $snapshot,
                'proof_file' => $path,
                'status' => 'pending',
                'duration_months' => round($maxDuration / 30),
                'admin_note' => null,
            ]
        );

        return redirect()->route('client.dashboard')->with('success', 'Pendaftaran berhasil dikirim! Mohon tunggu verifikasi admin.');
    }

    public function validateDiscount(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'package_id' => 'nullable|exists:packages,id',
            'package_ids' => 'nullable|array',
            'package_ids.*' => 'exists:packages,id',
        ]);

        $code = strtoupper(trim($request->code));
        
        $packageIds = $request->package_ids ?? ($request->package_id ? [$request->package_id] : []);
        if (empty($packageIds)) {
            return response()->json([
                'valid' => false,
                'message' => 'Silakan pilih paket terlebih dahulu.',
            ]);
        }

        $packages = \App\Models\Package::whereIn('id', $packageIds)->get();
        if ($packages->isEmpty()) {
            return response()->json([
                'valid' => false,
                'message' => 'Paket tidak ditemukan.',
            ]);
        }

        $totalPrice = $packages->sum('price');

        $discount = \App\Models\Discount::where('code', $code)->first();

        if (!$discount) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode diskon tidak valid.',
            ]);
        }

        if (!$discount->is_active) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode diskon tidak aktif.',
            ]);
        }

        $today = now()->startOfDay();

        if ($discount->start_date && $today->lt($discount->start_date)) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode diskon belum berlaku.',
            ]);
        }

        if ($discount->end_date && $today->gt($discount->end_date)) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode diskon sudah kedaluwarsa.',
            ]);
        }

        // Check min purchase requirement
        if ($discount->min_purchase && $totalPrice < $discount->min_purchase) {
            return response()->json([
                'valid' => false,
                'message' => 'Minimal pembelian untuk menggunakan voucher ini adalah Rp ' . number_format($discount->min_purchase, 0, ',', '.'),
            ]);
        }

        // Check max uses limit (quota)
        if ($discount->max_uses) {
            $usedCount = Payment::where('status', 'approved')
                ->where('package_data->discount_code', $discount->code)
                ->count();
            if ($usedCount >= $discount->max_uses) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Kuota penggunaan kode diskon ini sudah habis.',
                ]);
            }
        }

        // Calculate discount amount
        $discountAmount = 0;
        $percent = 0;

        if ($discount->type == 'percent') {
            $percent = $discount->value;
            $discountAmount = round($totalPrice * ($percent / 100));
            // Apply cap limit if defined
            if ($discount->max_limit && $discountAmount > $discount->max_limit) {
                $discountAmount = $discount->max_limit;
            }
        } else { // nominal
            $discountAmount = $discount->value;
            if ($discountAmount > $totalPrice) {
                $discountAmount = $totalPrice;
            }
            $percent = round(($discountAmount / $totalPrice) * 100);
        }

        $finalPrice = $totalPrice - $discountAmount;

        return response()->json([
            'valid' => true,
            'percent' => $percent,
            'discount_amount' => $discountAmount,
            'final_price' => $finalPrice,
        ]);
    }
}
