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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code');
            $table->integer('country')->nullable();
            $table->double('coupon_discount_rate');
            $table->boolean('coupon_stat')->default(false);
            $table->dateTime('coupon_satrt_date');
            $table->dateTime('coupon_end_date');
            $table->string('coupon_for');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
