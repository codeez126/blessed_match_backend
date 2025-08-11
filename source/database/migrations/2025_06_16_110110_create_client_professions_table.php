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
        Schema::create('client_professions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('occupation')->nullable()->constrained('occupations')->nullOnDelete();
            $table->string('occupation_grade')->nullable();

            $table->foreignId('education_id')->nullable()->constrained('educations')->nullOnDelete();

            $table->foreignId('employment_status_id')->nullable()->constrained('employment_statuses')->nullOnDelete();
            $table->integer('avg_income')->default(0);

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
        Schema::dropIfExists('client_professions');
    }
};
