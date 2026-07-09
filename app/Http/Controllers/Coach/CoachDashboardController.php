<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoachDashboardController extends Controller
{
    public function index()
    {
        $coach = \Illuminate\Support\Facades\Auth::user();
        
        // Count total clients before paginating
        $totalClients = $coach->clients()->count();
        
        // Paginate clients (10 per page)
        $clients = $coach->clients()->paginate(10);

        $sessions = \App\Models\CoachingSession::where('coach_id', $coach->id)->get();

        $sessionsThisWeek = \App\Models\CoachingSession::where('coach_id', $coach->id)
            ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        $events = $sessions->map(function ($session) {
            return [
                'title' => $session->title . ' (' . $session->client->name . ')',
                'start' => $session->date->toIso8601String(),
                'color' => $session->type == 'online' ? '#1572e8' : '#eeff00', // Blue for Online, Yellow for Offline
                'textColor' => $session->type == 'online' ? '#ffffff' : '#000000'
            ];
        });

        return view('coach.dashboard', compact('clients', 'events', 'sessionsThisWeek', 'totalClients'));
    }
}