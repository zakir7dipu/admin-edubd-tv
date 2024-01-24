<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTotalLectureTotalDurationColumnTypeInCmCourseTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cm_course_topics', function (Blueprint $table) {
            $table->integer('total_lecture')->change();
            $table->string('total_duration')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cm_course_topics', function (Blueprint $table) {
            $table->decimal('total_lecture', 10, 2)->change();
            $table->decimal('total_duration', 10, 2)->change();
        });
    }
}
