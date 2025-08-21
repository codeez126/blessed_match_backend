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
        Schema::create('user_profile_avgs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->decimal('onboarding1', 5, 2)->nullable();
            $table->decimal('onboarding2', 5, 2)->nullable();
            $table->decimal('onboarding3', 5, 2)->nullable();
            $table->decimal('onboarding4', 5, 2)->nullable();
            $table->decimal('onboarding5', 5, 2)->nullable();
            $table->decimal('onboarding6', 5, 2)->nullable();
            $table->decimal('total_avg', 5, 2)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profile_avgs');
    }
};
