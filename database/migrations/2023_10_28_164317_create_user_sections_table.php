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
        Schema::create('user_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('country_id');/* ->constrained()->onDelete('cascade'); */
            $table->integer('ordering')->nullable();
            $table->integer('paren_id')->nullable()->references('id')->on('user_sections')->onDelete('cascade');
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();
            $table->integer('user_id')->references('id')->on('clients')->onDelete('cascade');
            $table->string('language');
            $table->integer('default_MB_id');
            $table->integer('company_size');
            $table->integer('company_industry');
            $table->boolean('IsHaveLineBefore')->default(false);
            $table->boolean('IsActive');
            //softdelete
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_sections');
    }
};
