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
        Schema::create('patient', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->tinyInteger('sex')->nullable();
            $table->string('birthday')->nullable();
            $table->integer('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('papers')->nullable();
            $table->string('job')->nullable();
            $table->string('address')->nullable();
            $table->string('dependant')->nullable();
            $table->string('phone_dependant')->nullable();
            $table->string('data_sources')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient');
    }
};
