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
        Schema::create('raters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('survey_id')->references('id')->on('surveys')->onDelete('cascade');
            //candidate uuid
            $table->uuid('candidate_id');
            $table->uuid('rater_id');

            //type of rater
            $table->string('type');
            $table->boolean('send_status')->default(false);
            $table->dateTime('sent_date')->nullable();
            $table->boolean('reminder_status')->default(false);
            $table->dateTime('reminder_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('candidate_id')->references('id')->on('employees');//Employee id ();
            //rater uuid
            $table->foreign('rater_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raters');
    }
};
