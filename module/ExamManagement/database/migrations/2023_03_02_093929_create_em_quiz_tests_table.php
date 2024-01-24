<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmQuizTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('em_quiz_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('chapter_id')->constrained('em_exam_chapters');
            $table->decimal('total_quiz')->nullable()->default(0);
            $table->decimal('total_marks')->nullable()->default(0);
            $table->string('time_spent')->nullable()->default(0);
            $table->integer('is_completed')->nullable()->default(0);
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
        Schema::dropIfExists('em_quiz_tests');
    }
}
