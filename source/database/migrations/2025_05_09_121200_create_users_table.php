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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('otp')->nullable();

            $table->tinyInteger('type')->default(0); // 0=user, 1=matchmaker, 2=super admin
            $table->enum('auth_type', ['phone', 'email', 'google', 'facebook'])->default('phone');
            $table->string('auth_id')->nullable();

            $table->foreignId('match_maker_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('share_code', 10)->unique();
            $table->string('app_version')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_online')->default(0);
            $table->tinyInteger('onboarding_status')->default(0);
            $table->string('referal_code')->nullable();

            $table->tinyInteger('platform')->nullable(); // 1=Android, 2=iPhone, 3=Windows, 4=Mac
            $table->string('region')->nullable();

            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
