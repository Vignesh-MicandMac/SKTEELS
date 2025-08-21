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
        Schema::create('promotor_redeem_products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('promotor_id');
            $table->unsignedBigInteger('dealer_id')->nullable();
            $table->unsignedBigInteger('executive_id')->nullable();
            $table->unsignedBigInteger('product_id');

            $table->string('product_code', 200);
            $table->string('product_name', 200);

            $table->date('redeemed_date');
            $table->integer('promotor_points');
            $table->integer('product_redeem_points');
            $table->integer('balance_promotor_points');

            $table->enum('approved_status', ['0', '1', '2'])->default('0')
                ->comment('0 = waiting, 1 = approved, 2 = declined');
            $table->string('declined_reason', 255)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('promotor_id')->references('id')->on('promotors')->onDelete('cascade');
            $table->foreign('dealer_id')->references('id')->on('dealers')->onDelete('set null');
            $table->foreign('executive_id')->references('id')->on('executives')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotor_redeem_products');
    }
};
