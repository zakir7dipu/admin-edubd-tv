<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowInMenuColumnInEmExamCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('em_exam_categories', function (Blueprint $table) {
            $table->tinyInteger('show_in_menu')->nullable()->default(0)->after('serial_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('em_exam_categories', function (Blueprint $table) {
            $table->dropColumn('show_in_menu');
        });
    }
}
