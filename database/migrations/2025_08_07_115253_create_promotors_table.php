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
        Schema::create('promotors', function (Blueprint $table) {
            $table->id();
            $table->string('enroll_no', 200)->unique();
            $table->string('executive_id', 200)->nullable();
            $table->string('name', 200)->nullable();
            $table->longText('img_path')->nullable();
            $table->unsignedBigInteger('promotor_type_id')->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('whatsapp_no', 200)->nullable();
            $table->string('aadhaar_no', 100)->nullable();
            $table->string('door_no', 100)->nullable();
            $table->string('state_id', 200)->nullable();
            $table->string('district_id', 200)->nullable();
            $table->string('area_name', 200)->nullable();
            $table->string('pincode', 200)->nullable();
            $table->string('dob', 100)->nullable();
            $table->string('referral_mobile_no', 100)->nullable();
            $table->enum('approval_status', ['0', '1', '2']);
            $table->boolean('is_active')->default('1');
            $table->string('points', 100)->nullable();
            $table->string('otp', 100)->nullable();
            $table->string('redeem_otp', 100)->nullable();
            $table->dateTime('otp_generated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('promotor_type_id')->references('id')->on('promotor_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotors');
    }
};
