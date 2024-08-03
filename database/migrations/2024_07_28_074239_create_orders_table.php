<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Core\Constants\StatusOrder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('raffle_id')->constrained()->onDelete('cascade');
            $table->enum('status', StatusOrder::values())->default(StatusOrder::PENDING);
            $table->integer('total_coupons');
            $table->decimal('total_price', 10, 2);
            $table->string('qr_code_url')->nullable();
            $table->text('qr_code')->nullable();
            $table->integer('amount_1_coupon');
            $table->integer('amount_100_coupons');
            $table->integer('amount_250_coupons');
            $table->integer('amount_500_coupons');
            $table->integer('amount_1000_coupons');
            $table->integer('amount_5000_coupons');
            $table->integer('amount_10000_coupons');
            $table->string('order_id')->nullable();
            $table->string('code')->nullable();
            
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
