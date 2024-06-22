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
        Schema::create('customized_survey_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('survey_id');
            $table->integer('question_id');
            $table->integer('answer_value');
            $table->integer('cycle_number');
            $table->uuid('answered_by');
            $table->timestamps();
            $table->foreign('answered_by')->references('id')->on('respondents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customized_survey_answers');
    }
};
