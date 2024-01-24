<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropMapUrlFromWebCmsSiteInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('web_cms_site_infos', function (Blueprint $table) {
            $table->dropColumn('map_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('web_cms_site_infos', function (Blueprint $table) {
            $table->string('map_url')->after('description')->nullable();
        });
    }
}
