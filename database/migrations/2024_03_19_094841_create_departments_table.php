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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            //cascading on company id on delete
            $table->unsignedBigInteger('company_id')->references('id')->on('companies')->onDelete('cascade');
            // department name in english
            $table->string('name_en');
            // department name in arabic
            $table->string('name_ar');
            $table->string('dep_level');//0 ,1,2
            // bool is HR department
            $table->boolean('is_hr')->default(false);
            // department parent
            $table->unsignedBigInteger('parent_id')->nullable()->references('id')->on('departments')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
