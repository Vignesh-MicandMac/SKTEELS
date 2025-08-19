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
        Schema::create('promotor_dealer_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotor_id')->constrained('promotors')->onDelete('cascade');
            $table->foreignId('dealer_id')->constrained('dealers')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotor_dealer_mappings');
    }
};
