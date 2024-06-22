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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->integer('country')->nullable()->references('id')->on('countries')->onDelete('cascade');
            $table->integer('client')->nullable()->references('id')->on('clients')->onDelete('cascade');
            $table->string('name');
            $table->string('name_ar');
            $table->longText('objective')->nullable();
            $table->longText('objective_ar')->nullable();
            $table->longText('description');
            $table->longText('description_ar');
            $table->string('slug');
            $table->string('slug_ar');
            $table->integer('service_user');
            $table->string('service_icon');
            $table->boolean('FW_uploaded_video')->default(false);
            $table->string('framework_media_path');
            $table->boolean('FW_uploaded_video_ar')->default(false);
            $table->string('framework_media_path_ar');
            $table->integer('service_fileType');
            $table->boolean('service_uploaded_video')->default(false);
            $table->string('service_media_path');
            $table->integer('service_type');
            $table->boolean('is_active')->default(false);
            $table->boolean('candidate_raters_model')->default(false);
            $table->boolean('public_availability')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
