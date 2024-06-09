<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Raffle;

class HomeController extends Controller
{
    public function home()
    {
        $raffles = Raffle::all();

        return Inertia::render('Home', [
            'raffles' => $raffles
        ]);
    }
}
