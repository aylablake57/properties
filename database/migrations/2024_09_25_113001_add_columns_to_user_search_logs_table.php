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
        Schema::table('user_search_logs', function (Blueprint $table) {
            $table->string('location')->nullable();
            $table->string('type')->nullable();
            $table->string('sub_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_search_logs', function (Blueprint $table) {
            //
        });
    }
};
