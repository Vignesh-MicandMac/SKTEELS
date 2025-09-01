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
        Schema::table('dealers_stocks', function (Blueprint $table) {
            $table->string('updated_stock')->after('date_of_declined')->nullable();
            $table->string('previous_total_current_stock')->after('updated_stock')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dealers_stocks', function (Blueprint $table) {
            //
        });
    }
};
