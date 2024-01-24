<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmCourseCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cm_course_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('cm_course_categories');
            $table->text('name');
            $table->string('slug');
            $table->text('short_description')->nullable();
            $table->integer('serial_no')->unique();
            $table->string('icon', 500)->nullable();
            $table->tinyInteger('is_highlighted')->nullable()->default(0);
            $table->tinyInteger('show_in_menu')->nullable()->default(0);
            $table->tinyInteger('status')->default(1);
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
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
        Schema::dropIfExists('cm_course_categories');
    }
}
