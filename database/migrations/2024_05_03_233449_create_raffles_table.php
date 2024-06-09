<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('raffles', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('title')->nullable();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->decimal('price_1_coupon', 8, 2)->nullable();
            $table->decimal('price_100_coupons', 8, 2)->nullable();
            $table->decimal('price_250_coupons', 8, 2)->nullable();
            $table->decimal('price_500_coupons', 8, 2)->nullable();
            $table->decimal('price_1000_coupons', 8, 2)->nullable();
            $table->decimal('price_5000_coupons', 8, 2)->nullable();
            $table->decimal('price_10000_coupons', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raffles');
    }
};
