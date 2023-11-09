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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('department_id')->nullable();
            $table->smallInteger('status')->default(1)->index();
            $table->string('sex')->nullable();
            $table->timestamp('birth_day')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->string('identification')->nullable();
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
