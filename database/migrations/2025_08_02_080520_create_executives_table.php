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
        Schema::create('executives', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->nullable();
            $table->enum('role', ['0', '1'])->default('1');
            $table->string('mobile', 50)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('app_password', 200)->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();

            $table->string('otp', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('executives');
    }
};
