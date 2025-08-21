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
        Schema::create('match_requests', function (Blueprint $table) {
            $table->id();

            // Foreign keys (all required)
            $table->foreignId('requesting_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('requesting_mm_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiving_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiving_mm_id')->constrained('users')->onDelete('cascade');

            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            // Optional: Prevent duplicate requests
            $table->unique([
                'requesting_user_id',
                'receiving_user_id'
            ], 'unique_match_request');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_requests');
    }
};
