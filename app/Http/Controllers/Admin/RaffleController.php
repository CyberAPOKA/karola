<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreRaffleRequest;
use App\Models\Raffle;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class RaffleController extends Controller
{

    public function create()
    {
        return Inertia::render('Admin/Form/CreateRaffle');
    }

    public function store(StoreRaffleRequest $request)
    {
        // dd($request->all());

        $startDate = null;
        $endDate = null;
        $drawDate = null;

        if ($request->input('start')) {
            $startDate = Carbon::createFromFormat('d-m-Y H:i', $request->start);
        }

        if ($request->input('end')) {
            $endDate = Carbon::createFromFormat('d-m-Y H:i', $request->end);
        }

        if ($request->input('draw_date')) {
            $drawDate = Carbon::createFromFormat('d-m-Y', $request->draw_date);
        }

        Raffle::create([
            'title' => $request->title,
            'start' => $startDate,
            'end' => $endDate,
            'draw_date' => $drawDate,
            'price_1_coupon' => $request->price_1_coupon,
            'price_100_coupons' => $request->price_100_coupons,
            'price_250_coupons' => $request->price_250_coupons,
            'price_500_coupons' => $request->price_500_coupons,
            'price_1000_coupons' => $request->price_1000_coupons,
            'price_5000_coupons' => $request->price_5000_coupons,
            'price_10000_coupons' => $request->price_10000_coupons,
            'description' => $request->description,
            'image_path' => $request->photo->store('photos', 'public'),
        ]);
    }

    public function update(StoreRaffleRequest $request, $id)
    {
        // dd($request->all(), $id);
        $raffle = Raffle::findOrFail($id);
        $startDate = null;
        $endDate = null;

        if ($request->start) {
            $startDate = Carbon::createFromFormat('d-m-Y H:i', $request->start);
        }

        if ($request->start) {
            $endDate = Carbon::createFromFormat('d-m-Y H:i', $request->end);
        }

        $raffle->update([
            'title' => $request->title,
            'start' => $startDate,
            'end' => $endDate,
            'price_1_coupon' => $request->price_1_coupon,
            'price_100_coupons' => $request->price_100_coupons,
            'price_250_coupons' => $request->price_250_coupons,
            'price_500_coupons' => $request->price_500_coupons,
            'price_1000_coupons' => $request->price_1000_coupons,
            'price_5000_coupons' => $request->price_5000_coupons,
            'price_10000_coupons' => $request->price_10000_coupons,
            'description' => $request->description,
            'image_path' => $request->photo->store('photos', 'public'),
        ]);
    }

    public function raffle($id)
    {
        $raffle = Raffle::findOrFail($id);

        return Inertia::render('Admin/Form/EditRaffle', [
            'raffle' => $raffle
        ]);
    }
}
