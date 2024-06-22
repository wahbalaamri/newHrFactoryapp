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
        Schema::create('companies_sizes', function (Blueprint $table) {
            $table->id();
            $table->integer('country')->nullable()->references('id')->on('countries')->onDelete('cascade');
            $table->string('label');
            $table->string('label_ar');
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
        Schema::dropIfExists('companies_sizes');
    }
};
