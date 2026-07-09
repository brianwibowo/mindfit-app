<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminCoachController extends Controller
{
    public function index(Request $request)
    {
        $coaches = User::where('role', 'coach')->with(['coachProfile'])->withCount('clients')->latest()->paginate(8);

        // Return partial HTML for AJAX
        // requests (pagination without full reload)
        if ($request->ajax()) {
            return view('admin.coaches.partials.cards', compact('coaches'))->render();
        }

        return view('admin.coaches.index', compact('coaches'));
    }

    public function create()
    {
        return view('admin.coaches.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi data utama tanpa avatar agar tidak langsung membatalkan input data teks jika upload avatar gagal
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'specialization' => ['required', 'in:fitness,nutritionist'],
            'cropped_avatar' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'expertise' => ['nullable', 'string', 'max:255'],
        ]);

        $avatarPath = null;
        $avatarWarning = null;

        if ($request->filled('cropped_avatar')) {
            $imageData = $request->input('cropped_avatar');
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $type = strtolower($type[1]);
                $imageData = base64_decode($imageData);
                $fileName = 'avatars/' . uniqid() . '.' . $type;
                \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $imageData);
                $avatarPath = $fileName;
            }
        } elseif ($request->hasFile('avatar')) {
            // Validasi manual khusus file avatar agar data coach lainnya tetap dapat tersimpan
            $avatarValidator = \Illuminate\Support\Facades\Validator::make($request->only('avatar'), [
                'avatar' => ['file', 'mimes:jpeg,png,jpg,gif,heic,heif', 'max:2048'],
            ]);

            if ($avatarValidator->fails()) {
                $avatarWarning = 'Namun, foto profil gagal diunggah karena ukuran terlalu besar (maksimal 2MB) atau format tidak didukung.';
            } else {
                try {
                    $avatarPath = $request->file('avatar')->store('avatars', 'public');
                } catch (\Exception $e) {
                    $avatarWarning = 'Namun, foto profil gagal diunggah karena terjadi kesalahan sistem penyimpanan.';
                }
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'coach',
            'specialization' => $request->specialization,
            'avatar' => $avatarPath,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : true,
        ]);

        $user->coachProfile()->create([
            'specialization' => $request->expertise,
        ]);

        if ($avatarWarning) {
            return redirect()->route('admin.coaches.index')->with('warning', 'Akun Coach berhasil dibuat. ' . $avatarWarning);
        }

        return redirect()->route('admin.coaches.index')->with('success', 'Akun Coach berhasil dibuat.');
    }

    public function edit(User $coach)
    {
        return view('admin.coaches.edit', compact('coach'));
    }

    public function update(Request $request, User $coach)
    {
        // 1. Validasi data utama tanpa avatar agar tidak langsung membatalkan input data teks jika upload avatar gagal
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $coach->id],
            'phone' => ['required', 'string', 'max:20'],
            'specialization' => ['required', 'in:fitness,nutritionist'],
            'cropped_avatar' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'expertise' => ['nullable', 'string', 'max:255'],
        ];

        // Jika password diisi, maka tambahkan rule validasi password
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'specialization' => $request->specialization,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : false,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $avatarWarning = null;

        if ($request->filled('cropped_avatar')) {
            $imageData = $request->input('cropped_avatar');
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                // Delete old avatar if exists
                if ($coach->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($coach->avatar)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($coach->avatar);
                }
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $type = strtolower($type[1]);
                $imageData = base64_decode($imageData);
                $fileName = 'avatars/' . uniqid() . '.' . $type;
                \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $imageData);
                $data['avatar'] = $fileName;
            }
        } elseif ($request->hasFile('avatar')) {
            // Validasi manual khusus file avatar agar data coach lainnya tetap dapat diperbarui
            $avatarValidator = \Illuminate\Support\Facades\Validator::make($request->only('avatar'), [
                'avatar' => ['file', 'mimes:jpeg,png,jpg,gif,heic,heif', 'max:2048'],
            ]);

            if ($avatarValidator->fails()) {
                $avatarWarning = 'Namun, foto profil baru gagal diunggah karena ukuran terlalu besar (maksimal 2MB) atau format tidak didukung.';
            } else {
                try {
                    // Delete old avatar if exists
                    if ($coach->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($coach->avatar)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($coach->avatar);
                    }
                    $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
                } catch (\Exception $e) {
                    $avatarWarning = 'Namun, foto profil baru gagal diunggah karena terjadi kesalahan sistem penyimpanan.';
                }
            }
        }

        $coach->update($data);

        $coach->coachProfile()->updateOrCreate(
            ['user_id' => $coach->id],
            [
                'specialization' => $request->expertise,
            ]
        );

        if ($avatarWarning) {
            return redirect()->route('admin.coaches.index')->with('warning', 'Data Coach berhasil diperbarui. ' . $avatarWarning);
        }

        return redirect()->route('admin.coaches.index')->with('success', 'Data Coach berhasil diperbarui.');
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
    public function destroy(User $coach)
    {
        // Detach all clients first (optional, cascade handles it usually but good for safety)
        $coach->clients()->detach();

        // Delete user
        $coach->delete();

        return redirect()->route('admin.coaches.index')->with('success', 'Akun Coach berhasil dihapus.');
    }
}
