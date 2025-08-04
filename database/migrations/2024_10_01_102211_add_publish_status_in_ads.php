<?php

use App\Enums\AdStatus;
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
        // By ASfia
        Schema::table('ads', function (Blueprint $table) {
            $table->enum('status', array_column(AdStatus::cases(), 'value'))->default(AdStatus::Pending->value);
            $table->longText('cancel_reason')->nullable();
            $table->integer('cancelled_by')->nullable();
            $table->dateTime('cancelled_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            //
        });
    }
};
