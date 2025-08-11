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
        Schema::create('client_abouts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('full_name')->nullable();
            $table->string('profile_image')->nullable();
            $table->date('dob')->nullable();
            $table->boolean('gender')->default(0);

            $table->foreignId('marital_status_id')->nullable()->constrained('marital_statuses')->nullOnDelete();

            $table->string('profile_managed_by')->nullable();
            $table->tinyInteger('status')->default(0); // 0=pending, 1=approved, etc.
            $table->string('reason_txt')->nullable();
            $table->string('client_contact')->nullable();
            $table->string('cnic')->nullable();

            $table->tinyInteger('platform')->nullable();
            $table->string('region')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_abouts');
    }
};
