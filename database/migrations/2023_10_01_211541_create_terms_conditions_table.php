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
        Schema::create('terms_conditions', function (Blueprint $table) {
            $table->id();
            // cascade on country delete
            $table->integer('country_id')->references('id')->on('countries')->onDelete('cascade');
            //cascade on plan delete
            $table->integer('service')->nullable();
            $table->integer('plan_id')->nullable()->default(0)->references('id')->on('plans')->onDelete('cascade');
            $table->longText('arabic_text');
            $table->longText('english_text');
            $table->longText('arabic_title');
            $table->longText('english_title');
            $table->boolean('is_active')->default(0);
            $table->string('for')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terms_conditions');
    }
};
