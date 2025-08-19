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
        Schema::create('dealers', function (Blueprint $table) {
                $table->id(); 
                $table->string('tally_dealer_id', 200)->nullable();
                $table->string('name', 200)->nullable();
                $table->enum('role', ['0', '1'])->default('0'); 
                $table->string('address', 200)->nullable();
                $table->string('pincode', 50)->nullable();
                $table->string('state', 200)->nullable();
                $table->string('area', 200)->nullable();
                $table->string('district', 200)->nullable();
                $table->enum('action', ['0', '1'])->default('0');
                $table->timestamp('cdate')->useCurrent()->useCurrentOnUpdate();
                $table->string('mobile', 50)->nullable();
                $table->string('password', 100)->nullable();
                $table->string('gst_no', 200)->nullable();
                $table->string('otp', 50)->nullable();
                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealers');
    }
};
