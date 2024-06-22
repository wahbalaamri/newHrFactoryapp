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
        Schema::create('priorities_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('survey_id');
            $table->integer('question_id');
            $table->integer('answer_value');
            $table->uuid('answered_by')->nullable();
            //soft deletes
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('answered_by')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priorities_answers');
    }
};
