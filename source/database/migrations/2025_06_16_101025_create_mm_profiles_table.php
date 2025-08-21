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
        Schema::create('mm_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('full_name');
            $table->string('business_name')->nullable();
            $table->string('business_card')->nullable();
//            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->foreignId('gender_id')->nullable()->constrained('genders')->nullOnDelete();

            $table->date('dob')->nullable();

            $table->tinyInteger('experience_years')->default(0);

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('address')->nullable();
            $table->foreignId('office_type_id')->nullable()->constrained('office_types')->nullOnDelete();

            $table->string('my_refral_code')->nullable();
            $table->string('business_email')->nullable();
            $table->string('business_contact')->nullable();

            $table->boolean('is_registered')->default(false);
            $table->string('subscription')->nullable();

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
        Schema::dropIfExists('mm_profiles');
    }
};
