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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->nullable();
            $table->string('dha_name')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('cnic')->nullable();
            $table->string('name_of_firm')->nullable();
            $table->string('name_of_person')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('vendor_status')->nullable();
            $table->string('reg_date_withdha')->nullable();
            $table->string('firm_category')->nullable();
            $table->string('firm_type')->nullable();
            $table->string('firm_ntn')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
