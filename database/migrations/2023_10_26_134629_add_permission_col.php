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
        $tableNames = config('permission.table_names');
        Schema::table($tableNames['roles'], function (Blueprint $table) {

            $table->text('description')->nullable();
        });
        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->string('module')->default('admin')->index();
            $table->string('group',50)->nullable();
            $table->string('title',256)->nullable();
            $table->string('group_name', 512)->nullable();
            $table->integer('order_')->nullable()->default(1);
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
