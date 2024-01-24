<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegularFeeDiscountAmountColumnInCmCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cm_courses', function (Blueprint $table) {
            $table->decimal('regular_fee', 10, 2)->nullable()->default(0)->after('intro_video');
            $table->decimal('discount_amount', 10, 2)->nullable()->default(0)->after('regular_fee');
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
            $table->dropColumn('regular_fee');
            $table->dropColumn('discount_amount');
        });
    }
}
