<?php

namespace Module\WebsiteCMS\database\seeds;

use Illuminate\Database\Seeder;
use Module\WebsiteCMS\Models\BecomeInstructor;


class BecomeInstructorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BecomeInstructor::firstOrCreate([
            'id'            => 1
        ], [
            'title'                 => 'updated your title',
            'short_description'     => 'updated your short description',
        ]);
    }
}
