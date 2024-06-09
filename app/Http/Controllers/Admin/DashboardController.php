<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Raffle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $raffles = Raffle::all();
        return Inertia::render('Admin/Dashboard', [
            'raffles' => $raffles
        ]);
    }
}
