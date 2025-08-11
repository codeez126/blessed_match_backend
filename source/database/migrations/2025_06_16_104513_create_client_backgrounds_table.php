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
        Schema::create('client_backgrounds', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('province')->constrained('provinces')->cascadeOnDelete();
            $table->foreignId('city')->constrained('cities')->cascadeOnDelete();
            $table->foreignId('area')->constrained('areas')->cascadeOnDelete();


            $table->text('permanent_address')->nullable();
            $table->text('current_address')->nullable();

            $table->foreignId('house_status_id')->nullable()->constrained('house_statuses')->nullOnDelete();

            $table->string('house_size')->nullable();
            $table->text('background_description')->nullable();

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
        Schema::dropIfExists('client_backgrounds');
    }
};
