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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('client_id')->nullable()->references('id')->on('clients')->onDelete('cascade');
            $table->integer('partner_id')->nullable()->references('id')->on('clients')->onDelete('cascade');
            $table->integer('sector_id')->nullable()->references('id')->on('sectors')->onDelete('cascade');
            $table->integer('comp_id')->nullable()->references('id')->on('companies')->onDelete('cascade');
            $table->integer('dep_id')->nullable()->references('id')->on('departments')->onDelete('cascade');
            $table->string('user_type');
            $table->string('emp_id')->nullable();
            $table->boolean('is_main')->default(false);
            $table->boolean('isAdmin')->default(false);
            $table->string('password');
            $table->string('lang')->default('en');
            $table->boolean('hide_my_result')->default(false);
            //is_active
            $table->boolean('is_active')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
