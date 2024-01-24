<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsYoutubeEmbedLinkColumnInCmCourseLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cm_course_lessons', function (Blueprint $table) {
            $table->tinyInteger('is_youtube_embed_link')->nullable()->default(1)->after('is_video');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cm_course_lessons', function (Blueprint $table) {
            $table->dropColumn('is_youtube_embed_link');
        });
    }
}
