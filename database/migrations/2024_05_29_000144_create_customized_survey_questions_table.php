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
        Schema::create('customized_survey_questions', function (Blueprint $table) {
            $table->id();
            //cascading on practice delete
            $table->integer('practice_id')->references('id')->on('customized_survey_practices')->onDelete('cascade');
            $table->integer('system_question')->nullable();
            $table->string('question');
            $table->string('question_ar');
            $table->string('question_in')->nullable();
            $table->string('question_urdo')->nullable();
            $table->string('question_fr')->nullable();
            $table->string('question_sp')->nullable();
            $table->string('question_bngla')->nullable();
            $table->string('question_tr')->nullable();
            $table->string('question_pr')->nullable();
            $table->string('question_ru')->nullable();
            $table->string('question_ch')->nullable();
            $table->integer('respondent');
            //description
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('status');
            $table->boolean('IsENPS')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customized_survey_questions');
    }
};
