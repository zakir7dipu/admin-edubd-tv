<?php

namespace Module\CourseManagement\database\seeds;

use Illuminate\Database\Seeder;
use Module\CourseManagement\Models\CourseLevel;

class CourseLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseLevel::firstOrCreate(['name' => 'Beginner'],      ['created_by' => 1]);
        CourseLevel::firstOrCreate(['name' => 'Intermediate'],  ['created_by' => 1]);
        CourseLevel::firstOrCreate(['name' => 'Advanced'],      ['created_by' => 1]);
    }
}
