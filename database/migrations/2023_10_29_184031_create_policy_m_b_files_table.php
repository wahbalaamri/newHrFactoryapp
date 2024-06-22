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
        Schema::create('policy_m_b_files', function (Blueprint $table) {
            $table->id();
            //user id
            $table->integer('user_id');
            //string file name in English
            $table->string('name')->nullable();
            //string file name in Arabic
            $table->string('name_ar')->nullable();
            //string logo path
            $table->string('logo')->nullable();
            //soft delete
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy_m_b_files');
    }
};
