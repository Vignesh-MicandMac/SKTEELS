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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name', 200)->nullable();
            $table->string('product_code', 200)->unique()->nullable();
            $table->string('description', 200)->nullable();
            $table->string('img_path', 200)->nullable();
            $table->string('points', 200)->nullable();
            $table->enum('availability', ['0', '1', '2'])->default('1');
            $table->boolean('is_active')->default('1');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
