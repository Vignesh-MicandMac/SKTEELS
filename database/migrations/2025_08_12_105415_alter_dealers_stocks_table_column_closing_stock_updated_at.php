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
            $table->date('closing_stock_updated_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dealers_stocks', function (Blueprint $table) {
            $table->string('closing_stock_updated_at')->nullable()->change();
        });
    }
};
