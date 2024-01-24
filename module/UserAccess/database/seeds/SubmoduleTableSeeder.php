<?php

namespace Module\UserAccess\Database\Seeds;

use Illuminate\Database\Seeder;
use Module\UserAccess\Models\Submodule;

class SubmoduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Submodule::firstOrCreate([
            'id' => '1',
            'key'       => 'course_management',
            'name'      => 'Course Management'
        ], [
            'module_id' => 1
        ]);

        Submodule::firstOrCreate([
            'id' => '2',
            'key'       => 'website_cms',
            'name'      => 'Website CMS'
        ], [
            'module_id' => 2
        ]);

        Submodule::firstOrCreate([
            'id' => '3',
            'key'       => 'access_panel',
            'name'      => 'Access Panel'
        ], [
            'module_id' => 3
        ]);

        Submodule::firstOrCreate([
            'id' => '4',
            'key'       => 'exam_management',
            'name'      => 'Exam Management'
        ], [
            'module_id' => 4
        ]);

        Submodule::firstOrCreate([
            'id' => '5',
            'key'       => 'enrollment_management',
            'name'      => 'Enrollment Management'
        ], [
            'module_id' => 5
        ]);
        Submodule::firstOrCreate([
            'id' => '6',
            'key'       => 'instructor',
            'name'      => 'Instructor'
        ], [
            'module_id' => 6
        ]);
        Submodule::firstOrCreate([
            'id' => '7',
            'key'       => 'student',
            'name'      => 'Student'
        ], [
            'module_id' => 7
        ]);
        Submodule::firstOrCreate([
            'id' => '8',
            'key'       => 'report',
            'name'      => 'Report'
        ], [
            'module_id' => 8
        ]);
        Submodule::firstOrCreate([
            'id' => '9',
            'key'       => 'setup',
            'name'      => 'Setup'
        ], [
            'module_id' => 9
        ]);
    }
}
