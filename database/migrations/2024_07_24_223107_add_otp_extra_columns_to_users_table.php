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
        $fieldsToCheck = ['email_otp_code', 'otp_verified_via'];
        foreach ($fieldsToCheck as $field) {
            if (Schema::hasColumn('users', $field)) {
                Schema::dropColumns('users', $field);
            }
        }

        Schema::table('users', function (Blueprint $table) {
            $table->after('profile_image', function (Blueprint $table) {
                $table->string('email_otp_code')->nullable();
                $table->string('otp_verified_via')->nullable();;
            });            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['email_otp_code', 'otp_verified_via']);
        });
    }
};
