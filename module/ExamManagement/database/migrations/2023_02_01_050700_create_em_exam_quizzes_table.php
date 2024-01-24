<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmExamQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('em_exam_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_category_id')->constrained('em_exam_categories');
            $table->foreignId('exam_id')->constrained('em_exams');
            $table->foreignId('chapter_id')->constrained('em_exam_chapters');
            $table->text('title');
            $table->text('description')->nullable();
            $table->integer('serial_no');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('em_exam_quizzes');
    }
}
