<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hobbies', function (Blueprint $table) {
            $table->tinyInteger('type')->default(0);
            $table->unsignedBigInteger('main_hobby_id')->nullable()->after('type');
            $table->foreign('main_hobby_id')->references('id')->on('hobbies')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('hobbies', function (Blueprint $table) {
            $table->dropForeign(['main_hobby_id']);
            $table->dropColumn(['type', 'main_hobby_id']);
        });
    }

};
