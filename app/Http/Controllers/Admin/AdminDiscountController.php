<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminDiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::orderBy('created_at', 'desc')->paginate(7);
        return view('admin.discounts.index', compact('discounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:discounts,code|max:50',
            'type' => 'required|in:percent,nominal',
            'value' => 'required|integer|min:1',
            'max_limit' => 'nullable|integer|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'min_purchase' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
        ]);

        Discount::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'max_limit' => $request->max_limit,
            'max_uses' => $request->max_uses,
            'min_purchase' => $request->min_purchase,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.discounts.index')->with('success', 'Kode diskon berhasil dibuat.');
    }

    public function show(Discount $discount)
    {
        // Return JSON details for the Detail Pop-Up (Read) with real-time usage count
        $usedCount = Payment::where('status', 'approved')
            ->where('package_data->discount_code', $discount->code)
            ->count();

        return response()->json(array_merge($discount->toArray(), [
            'used_count' => $usedCount
        ]));
    }

    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:discounts,code,' . $discount->id,
            'type' => 'required|in:percent,nominal',
            'value' => 'required|integer|min:1',
            'max_limit' => 'nullable|integer|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'min_purchase' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'required|boolean',
        ]);

        $discount->update([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'max_limit' => $request->max_limit,
            'max_uses' => $request->max_uses,
            'min_purchase' => $request->min_purchase,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.discounts.index')->with('success', 'Kode diskon berhasil diperbarui.');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('admin.discounts.index')->with('success', 'Kode diskon berhasil dihapus.');
    }
}
