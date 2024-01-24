<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourseIdToWebCmsSliders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('web_cms_sliders', function (Blueprint $table) {
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
        Schema::table('web_cms_sliders', function (Blueprint $table) {
            //
        });
    }
}
