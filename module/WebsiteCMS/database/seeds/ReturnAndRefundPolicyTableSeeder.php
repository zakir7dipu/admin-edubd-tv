<?php

namespace Module\WebsiteCMS\database\seeds;

use Illuminate\Database\Seeder;
use Module\WebsiteCMS\Models\ReturnAndRefundPolicy;

class ReturnAndRefundPolicyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReturnAndRefundPolicy::firstOrCreate([
            'id'            => 1
        ], [
            'description'     => 'updated your description',
        ]);
    }
}
