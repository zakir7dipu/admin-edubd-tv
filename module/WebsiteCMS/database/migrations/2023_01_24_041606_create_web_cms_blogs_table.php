<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebCmsBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_cms_blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('web_cms_blog_categories');
            $table->text('title');
            $table->string('slug');
            $table->string('thumbnail_image');
            $table->string('cover_image')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('serial_no')->unique();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_cms_blogs');
    }
}
