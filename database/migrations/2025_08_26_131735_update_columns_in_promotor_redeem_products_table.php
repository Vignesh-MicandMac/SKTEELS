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
        Schema::table('promotor_redeem_products', function (Blueprint $table) {

            $table->string('product_code', 200)->nullable()->change();
            $table->string('product_name', 200)->nullable()->change();

            $table->date('redeemed_date')->nullable()->change();
            $table->integer('promotor_points')->nullable()->change();
            $table->integer('product_redeem_points')->nullable()->change();
            $table->integer('balance_promotor_points')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotor_redeem_products', function (Blueprint $table) {
            $table->string('product_code', 200)->nullable()->change();
            $table->string('product_name', 200)->nullable()->change();

            $table->date('redeemed_date')->nullable()->change();
            $table->integer('promotor_points')->nullable()->change();
            $table->integer('product_redeem_points')->nullable()->change();
            $table->integer('balance_promotor_points')->nullable()->change();
        });
    }
};
