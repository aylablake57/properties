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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('phase');
            $table->string('sector');
            $table->string('125_yards')->nullable();
            $table->string('133_yards')->nullable();
            $table->string('200_yards')->nullable();
            $table->string('250_yards')->nullable();
            $table->string('300_yards')->nullable();
            $table->string('400_yards')->nullable();
            $table->string('500_yards')->nullable();
            $table->string('800_yards')->nullable();
            $table->string('1000_yards')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
