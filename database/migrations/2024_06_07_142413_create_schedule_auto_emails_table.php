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
        Schema::create('schedule_auto_emails', function (Blueprint $table) {
            $table->id();
            //email id ==>> email content
            $table->integer('email_id')->references('id')->on('email_contents')->onDelete('cascade');
            $table->json('recivers')->nullable();
            $table->json('cc')->nullable();
            $table->date('send_date');
            $table->time('send_time');
            $table->boolean('status')->default(true);
            $table->boolean('send_status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_auto_emails');
    }
};
