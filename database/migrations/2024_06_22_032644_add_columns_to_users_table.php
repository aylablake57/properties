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
        $fieldsToCheck = ['landline', 'address', 'city', 'profile_image', 'opt_code', 'is_otp_verified'];
        foreach ($fieldsToCheck as $field) {
            if (Schema::hasColumn('users', $field)) {
                Schema::dropColumns('users', $field);
            }
        }

        Schema::table('users', function (Blueprint $table) {
            $table->after('cnic_number', function (Blueprint $table) {
                $table->string('landline')->nullable();
                $table->string('address')->nullable();
                $table->foreignId('city_id')->nullable();
                $table->string('profile_image')->nullable();
                $table->integer('otp_code')->nullable();
                $table->boolean('is_otp_verified')->default(false);
            });            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['landline', 'address', 'city', 'profile_image', 'opt_code', 'is_otp_verified']);
        });
    }
};
