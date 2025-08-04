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
        Schema::rename('property_amenities', 'amenity_property');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('amenity_property', 'property_amenities');
    }
};
