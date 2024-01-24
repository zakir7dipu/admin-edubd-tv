<?php

namespace Module\WebsiteCMS\database\seeds;

use Illuminate\Database\Seeder;
use Module\WebsiteCMS\Models\Support;

class SupportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Support::firstOrCreate([
            'id'            => 1
        ], [
            'description'     => 'updated your description',
        ]);
    }
}
