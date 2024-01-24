<?php

namespace Module\WebsiteCMS\database\seeds;

use Illuminate\Database\Seeder;
use Module\WebsiteCMS\Models\TermsAndCondition;

class TermsAndConditionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TermsAndCondition::firstOrCreate([
            'id'            => 1
        ], [
            'description'     => 'updated your description',
        ]);
    }
}
