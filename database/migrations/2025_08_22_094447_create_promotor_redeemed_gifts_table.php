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
        Schema::create('promotor_redeemed_gifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('promotor_id');
            $table->unsignedBigInteger('dealer_id')->nullable();
            $table->unsignedBigInteger('executive_id')->nullable();
            $table->string('product_img', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('promotor_id')->references('id')->on('promotors')->onDelete('cascade');
            $table->foreign('dealer_id')->references('id')->on('dealers')->onDelete('set null');
            $table->foreign('executive_id')->references('id')->on('executives')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotor_redeemed_gifts');
    }
};
