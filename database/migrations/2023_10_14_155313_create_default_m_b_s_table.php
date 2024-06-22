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
        Schema::create('default_m_b_s', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->integer('ordering')->nullable();
            $table->integer('paren_id')->nullable()->references('id')->on('default_m_b_s')->onDelete('cascade');
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('language');
            $table->integer('default_MB_id')->nullable();
            $table->integer('company_size')->nullable();
            $table->integer('company_industry')->nullable();
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
        Schema::dropIfExists('default_m_b_s');
    }
};
