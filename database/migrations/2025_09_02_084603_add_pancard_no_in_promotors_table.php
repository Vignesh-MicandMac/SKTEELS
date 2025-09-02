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
        Schema::table('promotors', function (Blueprint $table) {
            $table->string('aadhar_front_img')->after('aadhaar_no')->nullable();
            $table->string('aadhar_back_img')->after('aadhar_front_img')->nullable();
            $table->string('pan_card_no')->after('aadhar_back_img')->nullable();
            $table->string('pan_front_img')->after('pan_card_no')->nullable();
            $table->string('pan_back_img')->after('pan_front_img')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotors', function (Blueprint $table) {
            //
        });
    }
};
