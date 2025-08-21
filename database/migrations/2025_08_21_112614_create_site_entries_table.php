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
        Schema::create('site_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('promotor_type_id')->nullable();
            $table->string('site_id')->nullable();
            $table->string('site_name', 200)->nullable();
            $table->unsignedBigInteger('executive_id')->nullable();
            $table->unsignedBigInteger('dealer_id')->nullable();
            $table->string('brand_id', 100)->nullable();
            $table->dateTime('visit_date')->nullable();
            $table->string('img', 255)->nullable();
            $table->string('lat', 200)->nullable();
            $table->string('long', 200)->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('pincode_id')->nullable();
            $table->string('area', 200)->nullable();
            $table->string('door_no', 200)->nullable();
            $table->string('street_name', 200)->nullable();
            $table->string('building_stage', 200)->nullable();
            $table->string('floor_stage', 100)->nullable();
            $table->string('contact_no', 100)->nullable();
            $table->string('contact_person', 200)->nullable();
            $table->string('requirement_qty', 200)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('promotor_type_id')->references('id')->on('promotor_types')->onDelete('set null');
            $table->foreign('executive_id')->references('id')->on('executives')->onDelete('set null');
            $table->foreign('dealer_id')->references('id')->on('dealers')->onDelete('set null');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('set null');
            $table->foreign('pincode_id')->references('id')->on('pincodes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_entries');
    }
};
