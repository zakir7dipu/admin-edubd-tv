<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmEnrollmentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('em_enrollment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('em_enrollments');
            $table->foreignId('course_id')->constrained('cm_courses');
            $table->decimal('regular_fee', 10, 2)->nullable()->default(0);
            $table->decimal('discount_amount', 10, 2)->nullable()->default(0);
            $table->decimal('course_fee', 10, 2)->nullable()->default(0);
            $table->decimal('quantity', 10, 2)->nullable()->default(0);
            $table->decimal('total_fee', 10, 2)->virtualAs('course_fee * quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('em_enrollment_items');
    }
}
