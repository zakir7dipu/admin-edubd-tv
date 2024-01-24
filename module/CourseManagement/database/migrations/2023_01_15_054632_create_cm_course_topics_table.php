<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmCourseTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cm_course_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('cm_courses');
            $table->text('title');
            $table->decimal('total_lecture', 10, 2)->nullable();
            $table->decimal('total_duration', 10, 2)->nullable();
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
        Schema::dropIfExists('cm_course_topics');
    }
}
