<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmLessonQuizOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cm_lesson_quiz_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_quiz_id')->constrained('cm_lesson_quizzes');
            $table->string('name')->nullable();
            $table->string('answer')->nullable()->default('False');
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
        Schema::dropIfExists('cm_lesson_quiz_options');
    }
}
