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
        Schema::create('user_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('PlanId');
            $table->integer('UserId');
            $table->dateTime('StartDate');
            $table->dateTime('EndDate');
            $table->boolean('IsActive');
            $table->double('Price')->default(0.0);
            $table->boolean('IsFreeUsed');
            $table->boolean('IsFreeActive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_plans');
    }
};
