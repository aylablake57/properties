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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->integer('property_type_id');
            $table->text('property_subtype');
            $table->text('address');
            $table->text('country');
            $table->text('city');
            $table->integer('location_id');
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->text('street_view')->nullable();
            $table->double('plot_size');
            $table->integer('area_id');
            $table->double('price');
            $table->integer('is_installments')->default(0);
            $table->integer('is_ready_for_possession')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
