<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payment;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminClientController extends Controller
{
    public function index()
    {
        $status = request('status', 'pending');
        $search = request('search');

        $query = Payment::with(['user', 'package'])->latest();
        if ($status != 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $payments = $query->paginate(10)->withQueryString();

        if (request()->ajax()) {
            return view('admin.clients.partials.table_body', compact('payments', 'status'))->render();
        }

        return view('admin.clients.index', compact('payments', 'status'));
    }

    public function create()
    {
        $packages = Package::where('is_active', true)->get();
        
        // Fetch active coaches
        $coaches = User::where('role', 'coach')
            ->with(['coachProfile'])
            ->where('is_active', true)
            ->get();

        $pts = $coaches->where('specialization', 'fitness');
        $nutritionists = $coaches->where('specialization', 'nutritionist');

        return view('admin.clients.create', compact('packages', 'pts', 'nutritionists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'gender' => ['required', 'in:male,female'],
            'password' => ['required', Rules\Password::defaults()],
            'package_ids' => ['required', 'array'],
            'package_ids.*' => ['exists:packages,id'],
            'selected_pt_id' => ['required', 'exists:users,id'],
            'selected_nutritionist_id' => ['nullable', 'exists:users,id'],
        ]);

        // 1. Create client user
        $client = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'role' => 'client',
            'password' => Hash::make($request->password),
            'is_premium' => true,
            'is_active' => true,
        ]);

        // 2. Fetch packages to compute total price and duration
        $packages = Package::whereIn('id', $request->package_ids)->get();
        $primaryPackage = $packages->first();

        $packageNames = [];
        $totalPrice = 0;
        $maxDuration = 0;
        foreach ($packages as $pkg) {
            $packageNames[] = str_replace(['[Private] ', '[Group] ', '[Academy] ', '[Nutrition] '], '', $pkg->name);
            $totalPrice += $pkg->price;
            if ($pkg->duration_days > $maxDuration) {
                $maxDuration = $pkg->duration_days;
            }
        }
        $packageName = implode(' + ', $packageNames);

        $premiumUntil = now()->addDays($maxDuration);
        $client->update([
            'premium_until' => $premiumUntil,
        ]);

        // 3. Attach coaches
        // PT
        $ptCoach = User::find($request->selected_pt_id);
        if ($ptCoach) {
            $client->coaches()->attach($request->selected_pt_id, ['type' => 'fitness']);
        }
        // Nutritionist (if any)
        if ($request->selected_nutritionist_id) {
            $nutriCoach = User::find($request->selected_nutritionist_id);
            if ($nutriCoach) {
                $client->coaches()->attach($request->selected_nutritionist_id, ['type' => 'nutritionist']);
            }
        }

        // 4. Create Payment Record (Approved status)
        $snapshot = [
            'package_name' => $packageName,
            'package_price' => $totalPrice,
            'package_duration' => $maxDuration,
            'package_ids' => $request->package_ids,
            'addon_meal_plan' => false,
            'addon_price' => 0,
            'discount_code' => null,
            'discount_percent' => 0,
            'discount_amount' => 0,
            'total_price' => $totalPrice,
            'pt_id' => $request->selected_pt_id,
            'nutritionist_id' => $request->selected_nutritionist_id,
        ];

        Payment::create([
            'user_id' => $client->id,
            'package_id' => $primaryPackage->id,
            'package_data' => $snapshot,
            'proof_file' => 'manual_by_admin',
            'status' => 'approved',
            'duration_months' => round($maxDuration / 30),
            'subscription_start' => now(),
            'subscription_end' => $premiumUntil,
        ]);

        return redirect()->route('admin.clients.index', ['status' => 'approved'])->with('success', 'Klien Non-Gadget berhasil didaftarkan secara manual.');
    }
}
