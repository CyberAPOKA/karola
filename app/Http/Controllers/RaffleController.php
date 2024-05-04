<?php

namespace App\Http\Controllers;

use App\Models\Raffle;
use Illuminate\Http\Request;

class RaffleController extends Controller
{
    public function create(Request $request)
    {
        Raffle::create([
            'name' => $request->name,
            'price' => $request->price
        ]);
    }
}
