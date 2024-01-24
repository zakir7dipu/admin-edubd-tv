<?php

namespace Module\UserAccess\Database\Seeds;

use Illuminate\Database\Seeder;
use Module\UserAccess\Models\Module;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::firstOrCreate(['id' => '1','name' => 'Course Management'],      ['serial_no' => 1]);
        Module::firstOrCreate(['id' => '2','name' => 'Website CMS'],            ['serial_no' => 2]);
        Module::firstOrCreate(['id' => '3','name' => 'User Access'],            ['serial_no' => 3]);
        Module::firstOrCreate(['id' => '4','name' => 'Exam Management'],        ['serial_no' => 4]);
        Module::firstOrCreate(['id' => '5','name' => 'Enrollment Management'],  ['serial_no' => 5]);
        Module::firstOrCreate(['id' => '6','name' => 'Instructor'],             ['serial_no' => 6]);
        Module::firstOrCreate(['id' => '7','name' => 'Student'],                ['serial_no' => 7]);
        Module::firstOrCreate(['id' => '8','name' => 'Report'],                 ['serial_no' => 8]);
        Module::firstOrCreate(['id' => '9','name' => 'Setup'],                  ['serial_no' => 9]);
    }
}
