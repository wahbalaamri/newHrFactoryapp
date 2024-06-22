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
        Schema::create('partnerships', function (Blueprint $table) {
            $table->id();
            // cascading on partner delete
            $table->integer('partner_id')->references('id')->on('partners')->onDelete('cascade');
            // cascading on country delete
            $table->integer('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            //is_Exclusive
            $table->boolean('is_exclusive')->default(0);
            //is_active
            $table->boolean('is_active')->default(0);
            $table->softDeletes();
            //unique constraint on partner_id and country_id
            $table->unique(['partner_id', 'country_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partnerships');
    }
};
