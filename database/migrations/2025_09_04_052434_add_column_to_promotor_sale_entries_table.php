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
            $table->enum('so_approved_status', ['0', '1', '2'])->after('quantity');
            $table->string('so_declined_reason')->after('so_approved_status')->nullable();
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
