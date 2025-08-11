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
        Schema::create('sects', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Sect name (e.g., Shia, Sunni)
            $table->foreignId('religion_id')->constrained('religions')->onDelete('cascade'); // Foreign key to religions table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sects');
    }
};
