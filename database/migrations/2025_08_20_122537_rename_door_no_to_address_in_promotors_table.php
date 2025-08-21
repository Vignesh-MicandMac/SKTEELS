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
        Schema::table('promotors', function (Blueprint $table) {
            $table->string('door_no')->nullable()->change();
        });

        DB::statement("ALTER TABLE promotors CHANGE door_no address VARCHAR(255) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE promotors CHANGE address door_no VARCHAR(255) NULL");
    }
};
