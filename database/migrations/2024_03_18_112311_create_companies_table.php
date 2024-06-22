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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            //cascading on sector id on delete
            $table->unsignedBigInteger('sector_id')->references('id')->on('sectors')->onDelete('cascade');
            $table->unsignedBigInteger('client_id')->references('id')->on('clients')->onDelete('cascade');
            // company name in english
            $table->string('name_en');
            // company name in arabic
            $table->string('name_ar')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
