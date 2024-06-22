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
        Schema::create('email_contents', function (Blueprint $table) {
            $table->id();
            //string for email type
            $table->string('email_type');
            $table->integer('country')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('survey_id')->nullable();
            $table->text('subject');
            $table->text('subject_ar')->nullable();
            $table->longText('body_header');
            $table->longText('body_footer');
            $table->longText('body_header_ar')->nullable();
            $table->longText('body_footer_ar')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('use_client_logo')->default(0);
            $table->integer('created_by')->nullable();
            $table->string('created_by_type')->nullable();
            $table->string('email_for')->nullable();
            //logo
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
        Schema::dropIfExists('email_contents');
    }
};
