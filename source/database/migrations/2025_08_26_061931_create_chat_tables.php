<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('auth_user_id')->constrained('users');
            $table->foreignId('receiver_id')->constrained('users');
            $table->tinyInteger('status')->default(1)->comment('1=active,2=close/end');
            $table->nullableMorphs('chatable');
            $table->timestamps();
        });

        Schema::create('room_users', function (Blueprint $table) {
            $table->id();
            $table->string('socket_id')->nullable();
            $table->foreignId('chat_room_id')->constrained('chat_rooms')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained();
            $table->tinyInteger('is_online')->default(0);
            $table->timestamps();
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_room_id')->constrained('chat_rooms')->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users');
            $table->foreignId('receiver_id')->nullable()->constrained('users');
            $table->text('message')->nullable();
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('is_read')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('room_users');
        Schema::dropIfExists('chat_rooms');
    }
};
