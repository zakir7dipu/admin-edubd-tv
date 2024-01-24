<?php

namespace Module\UserAccess\Database\Seeds;

use Illuminate\Database\Seeder;
use Module\UserAccess\Models\ParentPermission;

class ParentPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ParentPermission::firstOrCreate([
            'id' => '1',
            'key'       => 'course',
            'name'      => 'Course'
        ], [
            'submodule_id' => 1
        ]);
        ParentPermission::firstOrCreate([
            'id' => '2',
            'key'       => 'lesson_quiz',
            'name'      => 'Lesson Quiz'
        ], [
            'submodule_id' => 1
        ]);

        ParentPermission::firstOrCreate([
            'id' => '3',
            'key'       => 'course_category',
            'name'      => 'Course Category'
        ], [
            'submodule_id' => 1
        ]);

        ParentPermission::firstOrCreate([
            'id' => '4',
            'key'       => 'slider',
            'name'      => 'Slider'
        ], [
            'submodule_id' => 2
        ]);

        ParentPermission::firstOrCreate([
            'id' => '5',
            'key'       => 'social_link',
            'name'      => 'Social Link'
        ], [
            'submodule_id' => 2
        ]);

        ParentPermission::firstOrCreate([
            'id' => '6',
            'key'       => 'testimonials',
            'name'      => 'Testimonials'
        ], [
            'submodule_id' => 2
        ]);

        ParentPermission::firstOrCreate([
            'id' => '7',
            'key'       => 'faq',
            'name'      => 'FAQ'
        ], [
            'submodule_id' => 2
        ]);

        ParentPermission::firstOrCreate([
            'id' => '8',
            'key'       => 'support',
            'name'      => 'Support'
        ], [
            'submodule_id' => 2
        ]);

        ParentPermission::firstOrCreate([
            'id' => '9',
            'key'       => 'page',
            'name'      => 'Page'
        ], [
            'submodule_id' => 2
        ]);

        ParentPermission::firstOrCreate([
            'id' => '10',
            'key'       => 'subscriber',
            'name'      => 'Subscriber'
        ], [
            'submodule_id' => 2
        ]);

        ParentPermission::firstOrCreate([
            'id' => '11',
            'key'       => 'blog',
            'name'      => 'Blog'
        ], [
            'submodule_id' => 2
        ]);
        ParentPermission::firstOrCreate([
            'id' => '12',
            'key'       => 'blog_cetegory',
            'name'      => 'Blog Cetegory'
        ], [
            'submodule_id' => 2
        ]);

        ParentPermission::firstOrCreate([
            'id' => '13',
            'key'       => 'about',
            'name'      => 'About'
        ], [
            'submodule_id' => 2
        ]);

        ParentPermission::firstOrCreate([
            'id' => '14',
            'key'       => 'terms_and_conditon',
            'name'      => 'Terms & Condition'
        ], [
            'submodule_id' => 2
        ]);

        ParentPermission::firstOrCreate([
            'id' => '15',
            'key'       => 'return_and_refund_policy',
            'name'      => 'Return & Refund Policy'
        ], [
            'submodule_id' => 2
        ]);

        ParentPermission::firstOrCreate([
            'id' => '16',
            'key'       => 'privacy_policy',
            'name'      => 'Privacy Policy'
        ], [
            'submodule_id' => 2
        ]);

        ParentPermission::firstOrCreate([
            'id' => '17',
            'key'       => 'become_instructor',
            'name'      => 'Become Instructor'
        ], [
            'submodule_id' => 2
        ]);

        ParentPermission::firstOrCreate([
            'id' => '18',
            'key'       => 'site_info',
            'name'      => 'Site Info'
        ], [
            'submodule_id' => 2
        ]);
        ParentPermission::firstOrCreate([
            'id' => '19',
            'key'       => 'admin_view',
            'name'      => 'Admin View'
        ], [
            'submodule_id' => 3
        ]);
        ParentPermission::firstOrCreate([
            'id' => '20',
            'key'       => 'permission_access',
            'name'      => 'Permission Access'
        ], [
            'submodule_id' => 3
        ]);

        ParentPermission::firstOrCreate([
            'id' => '21',
            'key'       => 'exam_category',
            'name'      => 'Exam Category'
        ], [
            'submodule_id' => 4
        ]);

        ParentPermission::firstOrCreate([
            'id' => '22',
            'key'       => 'exam_year',
            'name'      => 'Exam Year'
        ], [
            'submodule_id' => 4
        ]);

        ParentPermission::firstOrCreate([
            'id' => '23',
            'key'       => 'exam_institute',
            'name'      => 'Exam Institute'
        ], [
            'submodule_id' => 4
        ]);

        ParentPermission::firstOrCreate([
            'id' => '24',
            'key'       => 'exam',
            'name'      => 'Exam'
        ], [
            'submodule_id' => 4
        ]);

        ParentPermission::firstOrCreate([
            'id' => '25',
            'key'       => 'exam_quiz',
            'name'      => 'Exam Quiz'
        ], [
            'submodule_id' => 4
        ]);

        ParentPermission::firstOrCreate([
            'id' => '26',
            'key'       => 'enrollment_list',
            'name'      => 'Enrollment List'
        ], [
            'submodule_id' => 5
        ]);

        ParentPermission::firstOrCreate([
            'id' => '27',
            'key'       => 'coupon',
            'name'      => 'Coupon'
        ], [
            'submodule_id' => 5
        ]);
        ParentPermission::firstOrCreate([
            'id' => '28',
            'key'       => 'instructor_view',
            'name'      => 'Instructor View'
        ], [
            'submodule_id' => 6
        ]);
        // ParentPermission::firstOrCreate([
        //     'id' => '29',
        //     'key'       => 'instructor_list',
        //     'name'      => ' Instructor List'
        // ], [
        //     'submodule_id' => 6
        // ]);
        ParentPermission::firstOrCreate([
            'id' => '30',
            'key'       => 'student_view',
            'name'      => 'Student View'
        ], [
            'submodule_id' => 7
        ]);
        // ParentPermission::firstOrCreate([
        //     'id' => '31',
        //     'key'       => 'student_list',
        //     'name'      => 'Student List'
        // ], [
        //     'submodule_id' => 7
        // ]);
        ParentPermission::firstOrCreate([
            'id' => '32',
            'key'       => 'today_sales',
            'name'      => 'Today Sales'
        ], [
            'submodule_id' => 8
        ]);
        ParentPermission::firstOrCreate([
            'id' => '33',
            'key'       => 'sales_report',
            'name'      => 'Sales Report'
        ], [
            'submodule_id' => 8
        ]);
        ParentPermission::firstOrCreate([
            'id' => '34',
            'key'       => 'country',
            'name'      => 'Country'
        ], [
            'submodule_id' => 9
        ]);
        ParentPermission::firstOrCreate([
            'id' => '35',
            'key'       => 'state',
            'name'      => 'Sate'
        ], [
            'submodule_id' => 9
        ]);
        ParentPermission::firstOrCreate([
            'id' => '36',
            'key'       => 'city',
            'name'      => 'City'
        ], [
            'submodule_id' => 9
        ]);
        ParentPermission::firstOrCreate([
            'id' => '37',
            'key'       => 'vat_setting',
            'name'      => 'Vat Setting'
        ], [
            'submodule_id' => 9
        ]);
    }
}
