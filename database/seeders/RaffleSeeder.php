<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Carbon\Carbon;

class RaffleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $now = Carbon::now();

        for ($i = 0; $i < 10; $i++) {
            $title = Str::random(10);
            $start = Carbon::instance($faker->dateTimeBetween($now, $now->copy()->addDays(7)));
            $end = Carbon::instance($faker->dateTimeBetween($start->copy()->addDays(2), $start->copy()->addDays(14)));

            $price_1_coupon = $faker->randomFloat(2, 0.01, 0.99);
            $price_100_coupons = $faker->randomFloat(2, 0.01, $price_1_coupon);
            $price_250_coupons = $faker->randomFloat(2, 0.01, $price_100_coupons);
            $price_500_coupons = $faker->randomFloat(2, 0.01, $price_250_coupons);
            $price_1000_coupons = $faker->randomFloat(2, 0.01, $price_500_coupons);
            $price_5000_coupons = $faker->randomFloat(2, 0.01, $price_1000_coupons);
            $price_10000_coupons = $faker->randomFloat(2, 0.01, $price_5000_coupons);

            DB::table('raffles')->insert([
                'uuid' => Str::uuid(),
                'title' => $title,
                'start' => $start,
                'end' => $end,
                'price_1_coupon' => $price_1_coupon,
                'price_100_coupons' => $price_100_coupons,
                'price_250_coupons' => $price_250_coupons,
                'price_500_coupons' => $price_500_coupons,
                'price_1000_coupons' => $price_1000_coupons,
                'price_5000_coupons' => $price_5000_coupons,
                'price_10000_coupons' => $price_10000_coupons,
                'description' => $faker->paragraph,
                'image_path' => $faker->imageUrl(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}