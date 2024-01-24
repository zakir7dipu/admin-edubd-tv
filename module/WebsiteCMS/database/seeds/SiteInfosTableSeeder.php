<?php

namespace Module\WebsiteCMS\database\seeds;

use Illuminate\Database\Seeder;
use Module\WebsiteCMS\Models\SiteInfo;

class SiteInfosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteInfo::firstOrCreate([
            'id'            => 1
        ], [
            'site_name'     => 'Edu TV',
            'site_title'    => 'Edut TV',
            'address'       => 'Unknown Street',
        ]);
    }
}
