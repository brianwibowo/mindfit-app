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
            'type' => 'required|in:workout,nutrition,body_check',
            'photo' => 'nullable|image|max:2048', // 2MB
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
            'photo' => $photoPath,
            'description' => $request->description,
        ]);

        return redirect()->route('client.progress.index')->with('success', 'Progress berhasil disimpan!');
    }
}
