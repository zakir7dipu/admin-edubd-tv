<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmQuizOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('em_quiz_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_quiz_id')->constrained('em_exam_quizzes');
            $table->text('name');
            $table->tinyInteger('is_true')->default(0);
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
        Schema::dropIfExists('em_quiz_options');
    }
}
