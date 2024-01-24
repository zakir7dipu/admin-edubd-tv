<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cm_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_category_id')->constrained('cm_course_categories');
            $table->foreignId('course_level_id')->constrained('cm_course_levels');
            $table->foreignId('course_language_id')->nullable()->constrained('cm_course_languages');
            $table->string('course_type')->comment('Professional, Academic');
            $table->text('title');
            $table->string('slug', 500);
            $table->text('short_description')->nullable();
            $table->string('thumbnail_image', 500)->nullable();
            $table->string('slider_image', 500)->nullable();
            $table->string('intro_video', 500)->nullable();
            $table->decimal('course_fee', 10, 2)->nullable()->default(0);
            $table->decimal('average_rating', 10, 2)->nullable()->default(0);
            $table->tinyInteger('is_slider')->nullable()->default(0);
            $table->tinyInteger('is_premier')->nullable()->default(0);
            $table->tinyInteger('is_draft')->nullable()->default(0);
            $table->tinyInteger('is_auto_published')->nullable()->default(0);
            $table->tinyInteger('is_published')->nullable()->default(0);
            $table->foreignId('published_by')->nullable()->constrained('users');
            $table->dateTime('published_at')->nullable();
            $table->tinyInteger('status')->nullable()->default(0);
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
        Schema::dropIfExists('cm_courses');
    }
}
