<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminClientController extends Controller
{
    public function index()
    {
        $status = request('status', 'pending');

        $query = Payment::with('user')->latest();
        if ($status != 'all') {
            $query->where('status', $status);
        }
        $payments = $query->get();

        return view('admin.clients.index', compact('payments', 'status'));
    }
}
