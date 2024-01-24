<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropMultipleColumnFromWebCmsPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('web_cms_pages', function (Blueprint $table) {
            $table->dropColumn(['banner_image', 'image', 'short_description','seo_title','seo_description']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('web_cms_pages', function (Blueprint $table) {
            $table->string('banner_image')->nullable();
            $table->string('image')->nullable();
            $table->string('short_description', 500)->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
        });
    }
}
