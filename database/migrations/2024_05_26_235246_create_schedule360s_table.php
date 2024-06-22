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
        Schema::create('schedule360s', function (Blueprint $table) {
            $table->id();
            $table->uuid('candidate')->nullable();
            $table->string('rater_type');
            $table->integer('survey');
            $table->integer('client');
            $table->integer('sector')->nullable();
            $table->integer('company')->nullable();
            $table->integer('dep')->nullable();
            $table->string('email_type');
            $table->string('service_type');
            $table->date('send_date');
            $table->time('send_time');
            $table->boolean('send_status')->default(false);
            $table->dateTime('sent_date')->nullable();
            //cycle
            $table->integer('cycle')->nullable();
            $table->integer('cycle_value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule360s');
    }
};
