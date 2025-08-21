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
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_notifiable')->default(1);
            $table->boolean('dark_theme')->default(0);

            // Suggested fields:
            $table->string('language')->default('en'); // For multi-language support
            $table->boolean('show_online_status')->default(1); // For chat/visibility
            $table->boolean('receive_promotions')->default(1); // For app marketing
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};
