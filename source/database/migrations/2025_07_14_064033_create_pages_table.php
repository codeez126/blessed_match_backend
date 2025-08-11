<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_name')->nullable();
            $table->string('page_url')->unique();
            $table->string('page_heading')->nullable();
            $table->text('page_content')->nullable();
            $table->text('page_content2')->nullable();
            $table->string('page_banner')->nullable();
            $table->string('page_banner_alt')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('is_index')->default(false);
            $table->boolean('not_domain_specific')->default(false);
            $table->boolean('text_direction_right')->default(false);
            $table->boolean('lang_he')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
