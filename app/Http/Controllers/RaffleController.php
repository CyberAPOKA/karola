<?php

namespace App\Http\Controllers;

use App\Models\Raffle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RaffleController extends Controller
{
    public function raffle($id)
    {
        $raffle = Raffle::findOrFail($id);

        return Inertia::render('Raffle', [
            'raffle' => $raffle
        ]);
    }
}
