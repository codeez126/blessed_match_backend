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
        Schema::create('client_islamic_values', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('religion_id')->nullable()->constrained('religions')->nullOnDelete();
            $table->foreignId('sect_id')->nullable()->constrained('sects')->nullOnDelete();
            $table->foreignId('cast_id')->nullable()->constrained('casts')->nullOnDelete();
            $table->string('sub_cast_name')->nullable();

            $table->tinyInteger('prayer_frequency')->nullable(); // 1 = never ... 5 = regular

            $table->boolean('is_where_hijab')->default(false);
            $table->boolean('is_where_nikab')->default(false);
            $table->boolean('is_have_beared')->default(false);
            $table->boolean('quran_memorization')->default(false);

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
        Schema::dropIfExists('client_islamic_values');
    }
};
