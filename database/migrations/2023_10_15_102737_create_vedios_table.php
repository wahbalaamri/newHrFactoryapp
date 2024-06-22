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
        Schema::create('vedios', function (Blueprint $table) {
            $table->id();
            $table->boolean('Uploaded');
            $table->string('EmbadedEnglish');
            $table->string('UploadedEnglish');
            $table->string('EmbadedArabic');
            $table->string('UploadedArabic');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vedios');
    }
};
