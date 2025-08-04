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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('title');
            $table->longText('description');
            $table->string('price');
            $table->string('type');
            $table->string('sub_type');
            $table->bigInteger('city_id');
            $table->bigInteger('location_id');
            $table->string('featured_image')->nullable();
            $table->string('area_size');
            $table->string('area_unit');
            $table->unsignedBigInteger('area_size_value')->nullable()->comment('area size value in square feet');
            $table->string('purpose')->comment('for sale or rent');
            $table->string('number')->nullable()->comment('used to store property number');
            $table->boolean('ready_for_possession')->default(false);
            $table->boolean('installments_available')->default(false);
            $table->decimal('advance_amount', 15, 2)->nullable();
            $table->decimal('monthly_installment', 15, 2)->nullable();
            $table->enum('publish_status', ['Pending', 'Approved', 'Cancel','Sold'])->default('Pending');
            $table->timestamp('publish_status_changed_at')->nullable();
            $table->unsignedBigInteger('publish_status_changed_by')->nullable();
            $table->integer('no_of_installments')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('landline')->nullable();
            $table->string('angle')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
