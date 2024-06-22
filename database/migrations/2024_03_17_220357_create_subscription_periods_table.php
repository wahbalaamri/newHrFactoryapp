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
        Schema::create('subscription_periods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_ar');
            //subscription_period
            $table->integer('sbscription_period');
            //period_type
            $table->string('period_type');
            //discount
            $table->integer('discount')->nullable();
            //is_active
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_periods');
    }
};
