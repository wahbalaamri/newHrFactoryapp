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
        Schema::create('focal_points', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('focal_points');
    }
};
