<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('em_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_category_id')->constrained('em_exam_categories');
            $table->foreignId('exam_type_id')->nullable()->constrained('em_exam_types');
            $table->foreignId('exam_year_id')->nullable()->constrained('em_exam_years');
            $table->foreignId('institute_id')->nullable()->constrained('em_institutes');
            $table->text('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('serial_no');
            $table->tinyInteger('is_published')->default(0);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('em_exams');
    }
}
