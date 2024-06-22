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
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->integer('sector_id')->nullable()->references('id')->on('sectors')->onDelete('restrict');
            $table->integer('comp_id')->nullable()->references('id')->on('companies')->onDelete('restrict');
            $table->integer('dep_id')->nullable()->references('id')->on('departments')->onDelete('restrict');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('emp_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('age_generation')->nullable();
            $table->string('position')->nullable();
            $table->integer('employee_type');
            $table->boolean('isCandidate')->default(false);
            $table->boolean('isBoard')->default(false);
            $table->string('lang')->default('en');
            $table->json('acting_for')->nullable();
            $table->boolean('is_hr_manager')->default(false);
            $table->boolean('active')->default(true);
            $table->integer('added_by');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
