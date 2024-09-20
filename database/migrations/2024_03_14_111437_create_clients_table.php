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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->integer('country');
            $table->integer('industry');
            $table->integer('client_size');
            $table->integer('partner_id')->nullable();
            $table->integer('usr_max_number')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('phone')->nullable();
            $table->string('webiste')->nullable();
            $table->boolean('use_departments')->default(true);
            $table->boolean('use_sections')->default(false);
            $table->boolean('multiple_sectors')->default(false);
            $table->boolean('multiple_company')->default(false);
            $table->integer('added_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('clients');
    }
};
