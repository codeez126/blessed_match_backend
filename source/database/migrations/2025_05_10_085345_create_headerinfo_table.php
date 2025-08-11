<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeaderinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('headerinfo', function (Blueprint $table) {
            $table->id();  // Primary ID column
            $table->string('logo1', 255)->nullable();  // Logo 1
            $table->string('logo2', 255)->nullable();  // Logo 2
            $table->string('logo1alt', 255)->nullable();  // Logo 1 Alt Text
            $table->string('logo2alt', 255)->nullable();  // Logo 2 Alt Text
            $table->string('siteName', 255)->nullable();  // Site Name
            $table->string('siteUrl', 255)->nullable();  // Site URL
            $table->string('siteEmail', 255)->nullable();  // Site Email
            $table->string('sitePhone', 255)->nullable();  // Site Phone
            $table->string('address', 255)->nullable();  // Address
            $table->string('themecolor1', 255)->nullable();  // Theme Color 1
            $table->string('themecolor2', 255)->nullable();  // Theme Color 2
            $table->string('themecolor3', 255)->nullable();  // Theme Color 3
            $table->timestamps();  // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('headerinfo');
    }
}
