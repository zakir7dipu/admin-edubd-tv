<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullablePaymentMethodIdColumnInEmEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('em_enrollments', function (Blueprint $table) {
            $table->foreignId('payment_method_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('em_enrollments', function (Blueprint $table) {
            $table->foreignId('payment_method_id')->change();
        });
    }
}
