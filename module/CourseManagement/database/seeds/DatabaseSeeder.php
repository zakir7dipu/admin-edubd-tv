<?php

namespace Module\CourseManagement\Database\Seeds;

use Illuminate\Database\Seeder;
use Module\CourseManagement\database\seeds\CourseLanguagesTableSeeder;
use Module\CourseManagement\database\seeds\CourseLevelsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CourseLanguagesTableSeeder::class,
            CourseLevelsTableSeeder::class
        ]);
    }
}
