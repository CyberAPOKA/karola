<?php

namespace App\Http\Controllers;

use App\Models\Raffle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function getRaffles()
    {
        $isAdmin = auth('admin')->user();

        if ($isAdmin) {
            $raffles = Raffle::all();

            return response()->json($raffles);
        } else {
            return response()->json('Não autorizado');
        }
    }
}
