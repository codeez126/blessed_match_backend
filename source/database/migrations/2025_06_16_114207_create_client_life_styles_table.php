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
        Schema::create('client_life_styles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('height')->nullable(); // e.g. 5.7 ft
            $table->integer('weight')->nullable(); // in KG

            $table->foreignId('skin_color_id')->constrained('skin_types')->cascadeOnDelete();
            $table->tinyInteger('hair')->nullable();       // 1 - 9 (or any defined set)

            $table->boolean('disability')->default(false);
            $table->text('disability_details')->nullable();

            $table->boolean('health_issue')->default(false);
            $table->text('health_issue_details')->nullable();

            $table->boolean('is_smoking')->default(false);
            $table->boolean('is_alcoholic')->default(false);
            $table->boolean('is_tobaco_habit')->default(false);

            $table->boolean('willing_to_relocate')->default(false);

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
        Schema::dropIfExists('client_life_styles');
    }
};
