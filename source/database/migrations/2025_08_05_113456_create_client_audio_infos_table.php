<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('client_audio_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('onboarding_1')->nullable();
            $table->text('onboarding_2')->nullable();
            $table->text('onboarding_3')->nullable();
            $table->text('onboarding_4')->nullable();
            $table->text('onboarding_5')->nullable();
            $table->text('onboarding_6')->nullable();
            $table->text('onboarding_7')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_audio_infos');
    }
};
