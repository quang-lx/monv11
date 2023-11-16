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
        $all = new \Modules\Mon\Entities\Department();
        $all->name= 'Tất cả';
        $all->save();

        $cxn = new \Modules\Mon\Entities\Department();
        $cxn->name= 'Chưa xếp nhóm';
        $cxn->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
