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
        Schema::create('service_approaches', function (Blueprint $table) {
            $table->id();
            //cascading on service delete
            $table->integer('service')->references('id')->on('services')->onDelete('cascade');
            $table->longText('approach');
            $table->longText('approach_ar');
            // icon
            $table->string('icon')->nullable();
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
        Schema::dropIfExists('service_approaches');
    }
};
