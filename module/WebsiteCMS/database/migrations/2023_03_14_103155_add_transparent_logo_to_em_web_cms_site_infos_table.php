<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransparentLogoToEmWebCmsSiteInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('web_cms_site_infos', function (Blueprint $table) {
            $table->string('transparent_logo')->after('map_url')->nullable();
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
            $table->dropColumn('transparent_logo');
        });
    }
}
