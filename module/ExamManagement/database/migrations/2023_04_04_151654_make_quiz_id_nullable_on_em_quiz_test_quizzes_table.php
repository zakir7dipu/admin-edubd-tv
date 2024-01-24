<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeQuizIdNullableOnEmQuizTestQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('em_quiz_test_quizzes', function (Blueprint $table) {
            $table->foreignId('quiz_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('em_quiz_test_quizzes', function (Blueprint $table) {
            $table->foreignId('quiz_id')->nullable(false)->change();
        });
    }
}
