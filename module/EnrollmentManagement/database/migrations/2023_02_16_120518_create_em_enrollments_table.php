<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('em_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->foreignId('coupon_id')->nullable()->constrained('em_coupons');
            $table->string('invoice_no')->unique();
            $table->date('date');
            $table->decimal('total_quantity', 10, 2)->nullable()->default(0);
            $table->decimal('subtotal', 10, 2)->nullable()->default(0);
            $table->decimal('total_vat_amount', 10, 2)->nullable()->default(0);
            $table->decimal('item_total_discount_amount', 10, 2)->nullable()->default(0);
            $table->decimal('coupon_discount_amount', 10, 2)->nullable()->default(0);
            $table->decimal('grand_total', 10, 2)->virtualAs('subtotal + total_vat_amount - item_total_discount_amount - coupon_discount_amount');
            $table->string('payment_tnx_no')->nullable();
            $table->string('payment_status')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = Pending, 1 = Approved, 2 = Cancelled');
            $table->string('source')->comment('Website, Mobile');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->dateTime('approved_at')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users');
            $table->dateTime('cancelled_at')->nullable();
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
        Schema::dropIfExists('em_enrollments');
    }
}
