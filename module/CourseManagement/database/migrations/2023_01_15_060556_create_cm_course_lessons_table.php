<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmCourseLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cm_course_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('cm_courses');
            $table->foreignId('course_topic_id')->constrained('cm_course_topics');
            $table->text('title');
            $table->decimal('duration', 10, 2)->nullable();
            $table->string('video', 500)->nullable();
            $table->string('attachment', 500)->nullable();
            $table->longText('description')->nullable();
            $table->longText('assignment_description')->nullable();
            $table->tinyInteger('is_video')->nullable()->default(0);
            $table->tinyInteger('is_attachment')->nullable()->default(0);
            $table->tinyInteger('is_free')->nullable()->default(0);
            $table->tinyInteger('is_quiz')->nullable()->default(0);
            $table->tinyInteger('is_assignment')->nullable()->default(0);
            $table->tinyInteger('is_auto_published')->nullable()->default(0);
            $table->tinyInteger('is_published')->nullable()->default(0);
            $table->foreignId('published_by')->nullable()->constrained('users');
            $table->dateTime('published_at')->nullable();
            $table->tinyInteger('status')->nullable()->default(0);
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
        Schema::dropIfExists('cm_course_lessons');
    }
}
