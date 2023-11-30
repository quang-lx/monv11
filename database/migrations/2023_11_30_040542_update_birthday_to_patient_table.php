<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patient', function (Blueprint $table) {
            DB::statement('ALTER TABLE patient ALTER COLUMN birthday TYPE TIMESTAMP(0) WITHOUT TIME ZONE USING birthday::timestamp(0) without time zone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
