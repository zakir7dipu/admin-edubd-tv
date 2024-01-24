<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmExamChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('em_exam_chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('em_exams');
            $table->text('name');
            $table->integer('serial_no');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_published')->default(0);
            $table->foreignId('published_by')->nullable()->constrained('users');
            $table->dateTime('published_at')->nullable();
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
        Schema::dropIfExists('em_exam_chapters');
    }
}
