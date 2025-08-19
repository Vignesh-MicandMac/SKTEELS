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
        Schema::create('dealers_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dealer_id')->nullable();
            $table->string('open_balance', 200)->nullable();
            $table->string('dispatch', 200)->nullable();
            $table->string('total_stock', 200)->nullable();
            $table->date('dispatch_date')->nullable();
            $table->integer('promoter_sales')->nullable()->default(0);
            $table->string('balance_stock', 200)->nullable();
            $table->string('closing_stock', 200)->nullable();
            $table->string('other_sales', 200)->nullable();
            $table->integer('declined_stock')->nullable();
            $table->date('date_of_declined')->nullable();
            $table->string('total_current_stock', 200)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('dealer_id')->references('id')->on('dealers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealers_stocks');
    }
};
