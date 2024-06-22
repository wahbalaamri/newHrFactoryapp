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
        Schema::create('partner_focal_points', function (Blueprint $table) {
            $table->id();
            $table->integer('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('Email')->nullable();
            $table->string('phone')->nullable();
            $table->string('position')->nullable();
            //is_active
            $table->boolean('is_active')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_focal_points');
    }
};
