<?php

namespace Module\WebsiteCMS\database\seeds;

use Illuminate\Database\Seeder;
use Module\WebsiteCMS\Models\About;


class AboutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About::firstOrCreate([
            'id'            => 1
        ],
        [
            'title'                => 'Title',
            'short_description'    => 'this is short description',
            'description'          => 'this is description',
        ]);
    }
}
