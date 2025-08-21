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
        Schema::create('client_family_members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('type')->nullable(); // children, sibling, other
            $table->string('full_name')->nullable();
            $table->tinyInteger('age')->nullable();
//            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->foreignId('gender_id')->nullable()->constrained('genders')->nullOnDelete();

            $table->tinyInteger('martial_status')->default(1)->nullable();

            $table->text('description')->nullable();
            $table->string('designation')->nullable();
            $table->string('guardian_info')->nullable();

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
        Schema::dropIfExists('client_family_members');
    }
};
