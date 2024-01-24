<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmQuizTestQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('em_quiz_test_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_test_id')->constrained('em_quiz_tests');
            $table->foreignId('quiz_id')->constrained('em_exam_quizzes');
            $table->integer('mark')->nullable()->default(0);
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
        Schema::dropIfExists('em_quiz_test_quizzes');
    }
}
