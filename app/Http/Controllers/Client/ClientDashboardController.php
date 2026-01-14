<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientDashboardController extends Controller
{
    public function index()
    {
        $payment = \Illuminate\Support\Facades\Auth::user()->payments()->latest()->first();
        $packages = \App\Models\Package::where('is_active', true)->get();
        return view('client.dashboard', compact('payment', 'packages'));
    }
}