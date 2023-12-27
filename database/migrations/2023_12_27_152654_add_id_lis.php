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
        Schema::table('examination_service', function (Blueprint $table) {
            $table->string('id_lis', 300)->nullable();
        });
        Schema::table('examination_service_index', function (Blueprint $table) {
            $table->string('id_lis', 300)->nullable();
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
