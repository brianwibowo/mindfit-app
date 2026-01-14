<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminCoachController extends Controller
{
    public function index()
    {
        $coaches = User::where('role', 'coach')->withCount('clients')->get();
        return view('admin.coaches.index', compact('coaches'));
    }

    public function create()
    {
        return view('admin.coaches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'specialization' => ['required', 'in:fitness,nutritionist'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'coach',
            'specialization' => $request->specialization,
        ]);

        return redirect()->route('admin.coaches.index')->with('success', 'Akun Coach berhasil dibuat.');
    }

    public function show(User $coach)
    {
        // Get assigned clients
        $assignedClients = $coach->clients;

        // Get available clients (Active clients not assigned to THIS coach yet)
        // Note: A client can have multiple coaches (e.g. Fitness & Nutrition), so we just check if NOT already attached to this specific coach.
        $availableClients = User::where('role', 'client')
            ->where('is_premium', true)
            ->whereDoesntHave('coaches', function ($q) use ($coach) {
                $q->where('coach_id', $coach->id);
            })
            ->get();

        return view('admin.coaches.show', compact('coach', 'assignedClients', 'availableClients'));
    }

    public function assignClients(Request $request, User $coach)
    {
        $request->validate([
            'client_ids' => 'required|array',
            'client_ids.*' => 'exists:users,id'
        ]);

        // Attach clients. Assuming type based on coach specialization
        $type = $coach->specialization ?? 'fitness';

        foreach ($request->client_ids as $clientId) {
            $coach->clients()->attach($clientId, ['type' => $type]);
        }

        return redirect()->back()->with('success', 'Klien berhasil ditambahkan ke Coach ini.');
    }

    public function unassignClient(User $coach, User $client)
    {
        $coach->clients()->detach($client->id);
        return redirect()->back()->with('success', 'Klien berhasil dilepas dari Coach ini.');
    }

    public function assign(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'coach_id' => 'required|exists:users,id',
            'type' => 'required|in:fitness,nutritionist',
        ]);

        $client = User::find($request->client_id);

        // Use syncWithoutDetaching to allow multiple coaches (one fitness, one nutrition)
        // But table constraint uses composite unique keys.
        // We probably want 1 Fitness Coach AND 1 Nutritionist per client max.

        // For now, simple attach.
        try {
            $client->coaches()->attach($request->coach_id, ['type' => $request->type]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Coach tersebut sudah di-assign ke klien ini.');
        }

        return redirect()->back()->with('success', 'Coach berhasil di-assign!');
    }
}
