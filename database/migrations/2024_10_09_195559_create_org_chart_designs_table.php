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
        Schema::create('org_chart_designs', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->integer('level')->default(1);
            $table->string('user_label')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_chart_designs');
    }
};
