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
        Schema::create('customized_survey_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('survey')->references('id')->on('customized_surveys')->onDelete('cascade');
            $table->integer('cycle_number');
            $table->date('send_date');
            $table->time('send_time');
            $table->string('type');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customized_survey_schedules');
    }
};
