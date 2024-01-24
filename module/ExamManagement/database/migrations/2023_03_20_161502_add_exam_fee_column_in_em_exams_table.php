<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExamFeeColumnInEmExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('em_exams', function (Blueprint $table) {
            $table->decimal('exam_fee', 10, 2)->nullable()->default(0)->after('description');
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
            $table->dropColumn('exam_fee');
        });
    }
}
