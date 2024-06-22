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
        Schema::create('doc_files', function (Blueprint $table) {
            $table->id();
            $table->integer('country_id')->constraint()->onDelete('cascade');
            $table->integer('category_id')->constraint()->onDelete('cascade');
            $table->string('name');
            $table->string('name_ar');
            $table->string('eng_doc_path')->nullable();
            $table->string('arb_doc_path')->nullable();
            $table->string('eng_vedio')->nullable();
            $table->string('arb_vedio')->nullable();
            $table->boolean('isFileFree')->default(false);
            $table->boolean('isFileActive')->default(false);
            $table->boolean('isvedioYouTube')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_files');
    }
};
