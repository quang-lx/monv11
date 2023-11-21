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
        Schema::create('testing_service', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('code_lis')->unique();
            $table->string('name', 1024);
            $table->string('type', 1024)->nullable();
            $table->decimal('min_value', 32, 2)->nullable();
            $table->decimal('max_value', 32, 2)->nullable();
            $table->decimal('ref_value', 32, 2)->nullable();
            $table->string('unit')->nullable();
            $table->decimal('male_min_value', 32, 2)->nullable();
            $table->decimal('male_max_value', 32, 2)->nullable();
            $table->decimal('female_min_value', 32, 2)->nullable();
            $table->decimal('female_max_value', 32, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
