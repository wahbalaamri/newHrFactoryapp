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
        Schema::create('customized_surveys', function (Blueprint $table) {
            $table->id();
            $table->integer('client')->references('id')->on('clients')->onDelete('cascade');
            $table->integer('plan_id')->nullable()->references('id')->on('plans')->onDelete('cascade');
            $table->integer('subscription_plan_id')->nullable()->references('id')->on('client_subscriptions')->onDelete('cascade');
            $table->string('survey_title');
            $table->text('survey_des')->nullable();
            $table->boolean('candidate_raters_model')->default(false);
            $table->boolean('survey_stat')->default(0);
            //does it have cycles?
            $table->boolean('cycle_stat')->default(0);
            $table->string('cycle_duration')->nullable();
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->date('end_date')->nullable();
            //shoeld it send reminders?
            $table->boolean('reminder_stat')->default(0);
            $table->string('reminder_duration_type')->nullable();
            //reminder start at
            $table->date('reminder_start_date')->nullable();
            $table->time('reminder_start_time')->nullable();
            //is it mandatory to collect answers from all respondents?
            $table->boolean('mandatory_stat')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customized_surveys');
    }
};
