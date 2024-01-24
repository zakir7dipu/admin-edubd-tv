<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropExamTypeIdFromEmExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('em_exams', function (Blueprint $table) {
            $table->dropForeign('em_exams_exam_type_id_foreign');
            $table->dropColumn('exam_type_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('em_exams', function (Blueprint $table) {
            $table->foreignId('exam_type_id')->nullable()->after('exam_category_id')->constrained('em_exam_types');
        });
    }
}
