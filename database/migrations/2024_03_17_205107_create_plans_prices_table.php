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
        Schema::create('plans_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('plan')->references('id')->on('plans')->onDelete('cascade');
            //country
            $table->integer('country')->references('id')->on('countries')->onDelete('cascade');
            $table->double('annual_price');
            $table->double('monthly_price');
            $table->string('currency');
            // array of payment methods
            $table->json('payment_methods');
            //is_active
            $table->boolean('is_active')->default(0);
            //unique
            $table->unique(['plan', 'country']);
            //soft delete
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans_prices');
    }
};
