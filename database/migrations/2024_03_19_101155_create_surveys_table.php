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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->integer('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->integer('subscription_plan_id')->nullable()->references('id')->on('client_subscriptions')->onDelete('cascade');
            $table->string('survey_title');
            $table->text('survey_des')->nullable();
            $table->boolean('survey_stat')->default(0);
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
        Schema::dropIfExists('surveys');
    }
};
