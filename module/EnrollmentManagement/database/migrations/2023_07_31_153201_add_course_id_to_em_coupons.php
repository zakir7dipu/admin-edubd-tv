<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourseIdToEmCoupons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('em_coupons', function (Blueprint $table) {
            $table->foreignId('course_id')->after('id')->nullable()->constrained('cm_courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('em_coupons', function (Blueprint $table) {
            $table->foreignId('course_id');

        });
    }
}
