<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThumbnailImageBigToCmCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cm_courses', function (Blueprint $table) {
            $table->string('thumbnail_image_big')->after('thumbnail_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cm_courses', function (Blueprint $table) {
            $table->dropColumn('thumbnail_image_big');
        });
    }
}
