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
        Schema::table('site_entries', function (Blueprint $table) {
            $table->unsignedBigInteger('promotor_id')->after('dealer_id')->nullable();
            $table->foreign('promotor_id')->references('id')->on('promotors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_entries', function (Blueprint $table) {
            $table->dropColumn('promotor_id');
        });
    }
};
