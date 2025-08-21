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
        Schema::create('client_family_infos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('father_occupation')->nullable();
            $table->string('mother_occupation')->nullable();

            $table->foreignId('family_class_id')->nullable()->constrained('family_classes')->nullOnDelete();

            $table->boolean('is_father_alive')->default(true);
            $table->boolean('is_mother_alive')->default(true);

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
        Schema::dropIfExists('client_family_infos');
    }
};
