<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProgressLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoachClientProgressController extends Controller
{
    public function show(User $client)
    {
        // Check assignment
        if (!Auth::user()->clients->contains($client->id)) {
            abort(403, 'Unauthorized. This client is not assigned to you.');
        }

        $logs = ProgressLog::where('client_id', $client->id)->orderBy('date', 'desc')->get();
        return view('coach.clients.progress', compact('client', 'logs'));
    }
}
