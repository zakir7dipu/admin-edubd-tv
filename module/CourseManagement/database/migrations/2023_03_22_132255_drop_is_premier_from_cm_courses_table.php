<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIsPremierFromCmCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cm_courses', function (Blueprint $table) {
            $table->dropColumn('is_premier');
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
            $table->tinyInteger('is_premier')->nullable()->default(0);
        });
    }
}
