<?php

namespace Module\WebsiteCMS\database\seeds;

use Illuminate\Database\Seeder;
use Module\WebsiteCMS\Models\PrivacyPolicy;

class PrivacyPolicyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrivacyPolicy::firstOrCreate([
            'id'            => 1
        ], [
            'description'     => 'updated your description',
        ]);
    }
}
