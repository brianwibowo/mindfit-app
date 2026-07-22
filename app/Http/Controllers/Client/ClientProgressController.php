<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProgressLog;
use Illuminate\Support\Facades\Storage;

class ClientProgressController extends Controller
{
    public function index()
    {
        $logs = ProgressLog::where('client_id', Auth::id())->orderBy('date', 'desc')->get();
        return view('client.progress.index', compact('logs'));
    }

    public function charts()
    {
        $logs = ProgressLog::where('client_id', Auth::id())->orderBy('date', 'asc')->get();
        return view('client.progress.charts', compact('logs'));
    }

    public function create()
    {
        return view('client.progress.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'weight' => 'nullable|numeric',
            'waist' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'type' => 'required|in:workout,nutrition,body_check',
            'photo' => [
                'nullable',
                'file',
                'max:5120',
                function ($attribute, $value, $fail) {
                    if ($value && $value->isValid()) {
                        $ext = strtolower($value->getClientOriginalExtension());
                        $allowedExts = ['jpeg', 'jpg', 'png', 'gif', 'heic', 'heif', 'webp'];
                        if (!in_array($ext, $allowedExts)) {
                            $fail('Format foto progress harus berupa jpeg, png, jpg, gif, heic, heif, atau webp.');
                        }
                    }
                }
            ],
            'description' => 'nullable|string',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('progress_photos', 'public');
        }

        ProgressLog::create([
            'client_id' => Auth::id(),
            'date' => $request->date,
            'type' => $request->type,
            'weight' => $request->weight,
            'waist' => $request->waist,
            'height' => $request->height,
            'photo' => $photoPath,
            'description' => $request->description,
        ]);

        return redirect()->route('client.progress.index')->with('success', 'Progress berhasil disimpan!');
    }

    public function show($id)
    {
        $log = ProgressLog::where('client_id', Auth::id())->findOrFail($id);
        return view('client.progress.show', compact('log'));
    }

    public function edit($id)
    {
        $log = ProgressLog::where('client_id', Auth::id())->findOrFail($id);
        return view('client.progress.edit', compact('log'));
    }

    public function update(Request $request, $id)
    {
        $log = ProgressLog::where('client_id', Auth::id())->findOrFail($id);

        $request->validate([
            'date' => 'required|date',
            'weight' => 'nullable|numeric',
            'waist' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'type' => 'required|in:workout,nutrition,body_check',
            'photo' => [
                'nullable',
                'file',
                'max:5120',
                function ($attribute, $value, $fail) {
                    if ($value && $value->isValid()) {
                        $ext = strtolower($value->getClientOriginalExtension());
                        $allowedExts = ['jpeg', 'jpg', 'png', 'gif', 'heic', 'heif', 'webp'];
                        if (!in_array($ext, $allowedExts)) {
                            $fail('Format foto progress harus berupa jpeg, png, jpg, gif, heic, heif, atau webp.');
                        }
                    }
                }
            ],
            'description' => 'nullable|string',
        ]);

        $updateData = [
            'date' => $request->date,
            'type' => $request->type,
            'weight' => $request->weight,
            'waist' => $request->waist,
            'height' => $request->height,
            'description' => $request->description,
        ];

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($log->photo) {
                Storage::disk('public')->delete($log->photo);
            }
            $updateData['photo'] = $request->file('photo')->store('progress_photos', 'public');
        }

        $log->update($updateData);

        return redirect()->route('client.progress.index')->with('success', 'Progress berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $log = ProgressLog::where('client_id', Auth::id())->findOrFail($id);

        if ($log->photo) {
            Storage::disk('public')->delete($log->photo);
        }

        $log->delete();

        return redirect()->route('client.progress.index')->with('success', 'Progress berhasil dihapus.');
    }

    public function downloadPdf($id)
    {
        $log = ProgressLog::where('client_id', Auth::id())->with(['client', 'coach'])->findOrFail($id);

        $clientLogs = ProgressLog::where('client_id', $log->client_id)
            ->orderBy('date', 'asc')
            ->get();

        return view('layouts.pdf_report', compact('log', 'clientLogs'));
    }
}
