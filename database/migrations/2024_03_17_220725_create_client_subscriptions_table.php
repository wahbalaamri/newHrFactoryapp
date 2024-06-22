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
        Schema::create('client_subscriptions', function (Blueprint $table) {
            $table->id();
            //cascading on client delete
            $table->integer('client_id')->references('id')->on('clients')->onDelete('cascade');
            //cascading on plan delete
            $table->integer('plan_id')->references('id')->on('plans')->onDelete('cascade');
            //cascading on subscription_period delete
            $table->integer('period');
            $table->date('start_date');
            $table->date('end_date');
            $table->double('paid_amount');
            $table->double('discount');
            //array of plan features
            $table->json('plan_features')->nullable();
            //is_active
            $table->boolean('is_active')->default(0);
            $table->softDeletes();
            $table->timestamps();
            //unique constraint on client_id and plan_id and subscription_period
            $table->unique(['client_id', 'plan_id', 'period']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_subscriptions');
    }
};
