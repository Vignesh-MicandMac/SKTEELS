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
        Schema::table('promotor_sale_entries', function (Blueprint $table) {
            $table->unsignedBigInteger('site_id')->after('id')->nullable();

            $table->foreign('site_id')->references('id')->on('site_entries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotor_sale_entries', function (Blueprint $table) {
            //
        });
    }
};
