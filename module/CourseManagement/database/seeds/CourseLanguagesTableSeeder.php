<?php

namespace Module\CourseManagement\database\seeds;

use Illuminate\Database\Seeder;
use Module\CourseManagement\Models\CourseLanguage;

class CourseLanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseLanguage::firstOrCreate(['name' => 'English'], [
            'is_default'    => 1,
            'created_by'    => 1,
        ]);
        
        CourseLanguage::firstOrCreate(['name' => 'Bangla'], [
            'created_by'    => 1,
        ]);
    }
}
