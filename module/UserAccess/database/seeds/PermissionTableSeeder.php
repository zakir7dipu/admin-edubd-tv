<?php

namespace Module\UserAccess\Database\Seeds;

use Illuminate\Database\Seeder;
use Module\UserAccess\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate([
            'name'              => 'Course View',
            'slug'              => 'course-view',
            'description'       => 'Course View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 1
        ]);

        Permission::firstOrCreate([
            'name'              => 'Course Create',
            'slug'              => 'course-create',
            'description'       => 'Course Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 1
        ]);

        Permission::firstOrCreate([
            'name'              => 'Course Edit',
            'slug'              => 'course-edit',
            'description'       => 'Course Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 1
        ]);
        Permission::firstOrCreate([
            'name'              => 'Course Delete',
            'slug'              => 'course-delete',
            'description'       => 'Course Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 1
        ]);
        Permission::firstOrCreate([
            'name'              => 'Lesson Quiz View',
            'slug'              => 'lesson-quiz-view',
            'description'       => 'Lesson Quiz View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 2
        ]);

        Permission::firstOrCreate([
            'name'              => 'Lesson Quiz Create',
            'slug'              => 'lesson-quiz-create',
            'description'       => 'Lesson Quiz Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 2
        ]);

        Permission::firstOrCreate([
            'name'              => 'Lesson Quiz Edit',
            'slug'              => 'lesson-quiz-edit',
            'description'       => 'Lesson Quiz Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 2
        ]);
        Permission::firstOrCreate([
            'name'              => 'Lesson Quiz Delete',
            'slug'              => 'lesson-quiz-delete',
            'description'       => 'Lesson Quiz Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 2
        ]);

        Permission::firstOrCreate([
            'name'              => 'Course Category View',
            'slug'              => 'course-category-view',
            'description'       => 'Course Category View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 3
        ]);


        Permission::firstOrCreate([
            'name'              => 'Course Category Create',
            'slug'              => 'course-category-create',
            'description'       => 'Course Category Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 3
        ]);

        Permission::firstOrCreate([
            'name'              => 'Course Category Edit',
            'slug'              => 'course-category-edit',
            'description'       => 'Course Category Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 3
        ]);
        Permission::firstOrCreate([
            'name'              => 'Course Category Delete',
            'slug'              => 'course-category-delete',
            'description'       => 'Course Category Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 3
        ]);

        Permission::firstOrCreate([
            'name'              => 'Slider View',
            'slug'              => 'slider-view',
            'description'       => 'Slider View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 4
        ]);

        Permission::firstOrCreate([
            'name'              => 'Slider Create',
            'slug'              => 'slider-create',
            'description'       => 'Slider Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 4
        ]);

        Permission::firstOrCreate([
            'name'              => 'Slider Edit',
            'slug'              => 'slider-edit',
            'description'       => 'Slider Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 4
        ]);
        Permission::firstOrCreate([
            'name'              => 'Slider Delete',
            'slug'              => 'slider-delete',
            'description'       => 'Slider Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 4
        ]);

        Permission::firstOrCreate([
            'name'              => 'Social Link View',
            'slug'              => 'social-link-view',
            'description'       => 'Social Link View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 5
        ]);

        Permission::firstOrCreate([
            'name'              => 'Social Link Create',
            'slug'              => 'social-link-create',
            'description'       => 'Social Link Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 5
        ]);

        Permission::firstOrCreate([
            'name'              => 'Social Link Edit',
            'slug'              => 'social-link-edit',
            'description'       => 'Social Link Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 5
        ]);
        Permission::firstOrCreate([
            'name'              => 'Social Link Delete',
            'slug'              => 'social-link-delete',
            'description'       => 'Social Link Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 5
        ]);

        Permission::firstOrCreate([
            'name'              => 'Testimonials View',
            'slug'              => 'tstimonials-view',
            'description'       => 'Testimonials View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 6
        ]);

        Permission::firstOrCreate([
            'name'              => 'Testimonials Create',
            'slug'              => 'tstimonials-create',
            'description'       => 'Testimonials Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 6
        ]);

        Permission::firstOrCreate([
            'name'              => 'Testimonials Edit',
            'slug'              => 'tstimonials-edit',
            'description'       => 'Testimonials Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 6
        ]);
        Permission::firstOrCreate([
            'name'              => 'Testimonials Delete',
            'slug'              => 'tstimonials-delete',
            'description'       => 'Testimonials Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 6
        ]);

        Permission::firstOrCreate([
            'name'              => 'FAQ View',
            'slug'              => 'faq-view',
            'description'       => 'Faq View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 7
        ]);

        Permission::firstOrCreate([
            'name'              => 'FAQ Create',
            'slug'              => 'faq-create',
            'description'       => 'Faq Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 7
        ]);

        Permission::firstOrCreate([
            'name'              => 'FAQ Edit',
            'slug'              => 'faq-edit',
            'description'       => 'Faq Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 7
        ]);
        Permission::firstOrCreate([
            'name'              => 'FAQ Delete',
            'slug'              => 'faq-delete',
            'description'       => 'Faq Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 7
        ]);

        Permission::firstOrCreate([
            'name'              => 'Support View',
            'slug'              => 'support-view',
            'description'       => 'Support View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 8
        ]);

        Permission::firstOrCreate([
            'name'              => 'Support Create',
            'slug'              => 'support-create',
            'description'       => 'Support Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 8
        ]);


        Permission::firstOrCreate([
            'name'              => 'Support Edit',
            'slug'              => 'support-edit',
            'description'       => 'Support Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' =>8
        ]);
        Permission::firstOrCreate([
            'name'              => 'Support Delete',
            'slug'              => 'support-delete',
            'description'       => 'Support Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 8
        ]);


        Permission::firstOrCreate([
            'name'              => 'Page View',
            'slug'              => 'page-view',
            'description'       => 'Page View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 9
        ]);


        Permission::firstOrCreate([
            'name'              => 'Page Create',
            'slug'              => 'page-create',
            'description'       => 'Page Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 9
        ]);


        Permission::firstOrCreate([
            'name'              => 'Page Edit',
            'slug'              => 'page-edit',
            'description'       => 'Page Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 9
        ]);
        Permission::firstOrCreate([
            'name'              => 'Page Delete',
            'slug'              => 'page-delete',
            'description'       => 'Page Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 9
        ]);

        Permission::firstOrCreate([
            'name'              => 'Subscriber View',
            'slug'              => 'subscriber-view',
            'description'       => 'Subscriber View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 10
        ]);

        Permission::firstOrCreate([
            'name'              => 'Blog View',
            'slug'              => 'blog-view',
            'description'       => 'Blog View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 11
        ]);

        Permission::firstOrCreate([
            'name'              => 'Blog Create',
            'slug'              => 'blog-crate',
            'description'       => 'Blog Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 11
        ]);

        Permission::firstOrCreate([
            'name'              => 'Blog Edit',
            'slug'              => 'blog-edit',
            'description'       => 'Blog Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 11
        ]);
        Permission::firstOrCreate([
            'name'              => 'Blog Delete',
            'slug'              => 'blog-delete',
            'description'       => 'Blog Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 11
        ]);
        Permission::firstOrCreate([
            'name'              => 'Blog Cetegory View',
            'slug'              => 'blog-cetegory-view',
            'description'       => 'Blog Cetegory View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 12
        ]);

        Permission::firstOrCreate([
            'name'              => 'Blog Cetegory Create',
            'slug'              => 'blog-cetegory-create',
            'description'       => 'Blog Cetegory Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 12
        ]);

        Permission::firstOrCreate([
            'name'              => 'Blog Cetegory Edit',
            'slug'              => 'blog-cetegory-edit',
            'description'       => 'Blog Cetegory Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 12
        ]);
        Permission::firstOrCreate([
            'name'              => 'Blog Cetegory Delete',
            'slug'              => 'blog-cetegory-delete',
            'description'       => 'Blog Cetegory Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 12
        ]);

        Permission::firstOrCreate([
            'name'              => 'About View',
            'slug'              => 'about-view',
            'description'       => 'About Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 13
        ]);

        Permission::firstOrCreate([
            'name'              => 'Terms & Condition View',
            'slug'              => 'terms-and-condition-view',
            'description'       => 'Terms & Condition View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 14
        ]);

        Permission::firstOrCreate([
            'name'              => 'Return & Refund Policy View',
            'slug'              => 'return-and-refund-policy-view',
            'description'       => 'Return And Refund Policy View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 15
        ]);

        Permission::firstOrCreate([
            'name'              => 'Privacy Policy View',
            'slug'              => 'privacy-policy-view',
            'description'       => 'Privacy Policy View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 16
        ]);

        Permission::firstOrCreate([
            'name'              => 'Become Instructor View',
            'slug'              => 'become-instructor-view',
            'description'       => 'Become Instructor View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 17
        ]);

        Permission::firstOrCreate([
            'name'              => 'Site Info',
            'slug'              => 'site-info',
            'description'       => 'Site Info Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 18
        ]);


        Permission::firstOrCreate([
            'name'              => 'Exam Category',
            'slug'              => 'exam-category',
            'description'       => 'Exam Category Description',
            'created_by'        => 1,
            'updated_by'        => 1
        ], [
            'parent_permission_id' => 21
        ]);

        Permission::firstOrCreate([
            'name'              => 'Exam Category Create',
            'slug'              => 'exam-category-create',
            'description'       => 'Exam Category Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 21
        ]);

        Permission::firstOrCreate([
            'name'              => 'Exam Category Edit',
            'slug'              => 'exam-category-edit',
            'description'       => 'Exam Category Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 21
        ]);
        Permission::firstOrCreate([
            'name'              => 'Exam Category Delete',
            'slug'              => 'exam-category-delete',
            'description'       => 'Exam Category Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 21
        ]);

        Permission::firstOrCreate([
            'name'              => 'Exam Year',
            'slug'              => 'exam-year',
            'description'       => 'Exam Year Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 22
        ]);


        Permission::firstOrCreate([
            'name'              => 'Exam Year Create',
            'slug'              => 'exam-year-create',
            'description'       => 'Exam Year Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 22
        ]);

        Permission::firstOrCreate([
            'name'              => 'Exam Year Edit',
            'slug'              => 'exam-year-edit',
            'description'       => 'Exam Year Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 22
        ]);
        Permission::firstOrCreate([
            'name'              => 'Exam Year Delete',
            'slug'              => 'exam-year-delete',
            'description'       => 'Exam Year Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 22
        ]);


        Permission::firstOrCreate([
            'name'              => 'Exam Institute',
            'slug'              => 'exam-institute',
            'description'       => 'Exam Institute Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 23
        ]);

        Permission::firstOrCreate([
            'name'              => 'Exam Institute Create',
            'slug'              => 'exam-institute-create',
            'description'       => 'Exam Institute Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 23
        ]);

        Permission::firstOrCreate([
            'name'              => 'Exam Institute Edit',
            'slug'              => 'exam-institute-edit',
            'description'       => 'Exam Institute Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 23
        ]);
        Permission::firstOrCreate([
            'name'              => 'Exam Institute Delete',
            'slug'              => 'exam-institute-delete',
            'description'       => 'Exam Institute Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 23
        ]);

        Permission::firstOrCreate([
            'name'              => 'Exam View',
            'slug'              => 'exam-view',
            'description'       => 'Exam View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 24
        ]);

        Permission::firstOrCreate([
            'name'              => 'Exam Create',
            'slug'              => 'exam-create',
            'description'       => 'Exam Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 24
        ]);

        Permission::firstOrCreate([
            'name'              => 'Exam Edit',
            'slug'              => 'exam-edit',
            'description'       => 'Exam Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 24
        ]);
        Permission::firstOrCreate([
            'name'              => 'Exam Delete',
            'slug'              => 'exam-delete',
            'description'       => 'Exam Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 24
        ]);

        Permission::firstOrCreate([
            'name'              => 'Exam Quiz',
            'slug'              => 'exam-quiz',
            'description'       => 'Exam Quiz Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 25
        ]);

        Permission::firstOrCreate([
            'name'              => 'Exam Quiz Create',
            'slug'              => 'exam-quiz-create',
            'description'       => 'Exam Quiz Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 25
        ]);

        Permission::firstOrCreate([
            'name'              => 'Exam Quiz Edit',
            'slug'              => 'exam-quiz-edit',
            'description'       => 'Exam Quiz Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 25
        ]);
        Permission::firstOrCreate([
            'name'              => 'Exam Quiz Delete',
            'slug'              => 'exam-quiz-delete',
            'description'       => 'Exam Quiz Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 25
        ]);

        Permission::firstOrCreate([
            'name'              => 'Enrollment List View',
            'slug'              => 'enrollment-list-vew',
            'description'       => 'Exam List View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 26
        ]);
        Permission::firstOrCreate([
            'name'              => 'Enrollment List Delete',
            'slug'              => 'enrollment-list-delete',
            'description'       => 'Exam List Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 26
        ]);


        Permission::firstOrCreate([
            'name'              => 'Coupon View',
            'slug'              => 'coupon-vew',
            'description'       => 'Coupon View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 27
        ]);

        Permission::firstOrCreate([
            'name'              => 'Coupon Create',
            'slug'              => 'coupon-create',
            'description'       => 'Coupon Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 27
        ]);

        Permission::firstOrCreate([
            'name'              => 'Coupon Edit',
            'slug'              => 'coupon-edit',
            'description'       => 'Coupon Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 27
        ]);
        Permission::firstOrCreate([
            'name'              => 'Coupon Delete',
            'slug'              => 'coupon-delete',
            'description'       => 'Coupon Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 27
        ]);
        Permission::firstOrCreate([
            'name'              => 'Instructor View',
            'slug'              => 'instructor-view',
            'description'       => 'Instructor View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 28
        ]);
        Permission::firstOrCreate([
            'name'              => 'Instructor Create',
            'slug'              => 'instructor-create',
            'description'       => 'Instructor Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 28
        ]);
        Permission::firstOrCreate([
            'name'              => 'Instructor Edit',
            'slug'              => 'instructor-edit',
            'description'       => 'Instructor Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 28
        ]);
        Permission::firstOrCreate([
            'name'              => 'Instructor Delete',
            'slug'              => 'instructor-delete',
            'description'       => 'Instructor Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 28
        ]);
        Permission::firstOrCreate([
            'name'              => 'Student View',
            'slug'              => 'student-view',
            'description'       => 'Student View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 30
        ]);
        Permission::firstOrCreate([
            'name'              => 'Student Create',
            'slug'              => 'student-create',
            'description'       => 'Student Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 30
        ]);
        Permission::firstOrCreate([
            'name'              => 'Student Edit',
            'slug'              => 'student-edit',
            'description'       => 'Student Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 30
        ]);
        Permission::firstOrCreate([
            'name'              => 'Student Delete',
            'slug'              => 'student-delete',
            'description'       => 'Student Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 30
        ]);
        Permission::firstOrCreate([
            'name'              => 'Today Sales',
            'slug'              => 'todat-sales',
            'description'       => 'Today Sales Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 32
        ]);
        Permission::firstOrCreate([
            'name'              => 'Sales Report',
            'slug'              => 'sales-report',
            'description'       => 'Sales Report Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 33
        ]);
        Permission::firstOrCreate([
            'name'              => 'Country View',
            'slug'              => 'country-view',
            'description'       => 'Country View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 34
        ]);
        Permission::firstOrCreate([
            'name'              => 'Sate View',
            'slug'              => 'sate-view',
            'description'       => 'Sate View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 35
        ]);
        Permission::firstOrCreate([
            'name'              => 'Sate Create',
            'slug'              => 'sate-create',
            'description'       => 'Sate Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 35
        ]);
        Permission::firstOrCreate([
            'name'              => 'Sate Edit',
            'slug'              => 'sate-edit',
            'description'       => 'Sate Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 35
        ]);
        Permission::firstOrCreate([
            'name'              => 'Sate Delete',
            'slug'              => 'sate-delete',
            'description'       => 'Sate Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 35
        ]);
        Permission::firstOrCreate([
            'name'              => 'City View',
            'slug'              => 'city-view',
            'description'       => 'City View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 36
        ]);
        Permission::firstOrCreate([
            'name'              => 'City Create',
            'slug'              => 'city-create',
            'description'       => 'City Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 36
        ]);
        Permission::firstOrCreate([
            'name'              => 'City Edit',
            'slug'              => 'city-edit',
            'description'       => 'City Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 36
        ]);
        Permission::firstOrCreate([
            'name'              => 'City Delete',
            'slug'              => 'city-delete',
            'description'       => 'City Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 36
        ]);
        Permission::firstOrCreate([
            'name'              => 'Vat Setting',
            'slug'              => 'vat-setting-edit',
            'description'       => 'Vat Setting Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 37
        ]);
        Permission::firstOrCreate([
            'name'              => 'Admin View',
            'slug'              => 'admin-view',
            'description'       => 'Admin View Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 19
        ]);
        Permission::firstOrCreate([
            'name'              => 'Admin Create',
            'slug'              => 'admin-create',
            'description'       => 'Admin Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 19
        ]);
        Permission::firstOrCreate([
            'name'              => 'Admin Edit',
            'slug'              => 'admin-edit',
            'description'       => 'Admin Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 19
        ]);
        Permission::firstOrCreate([
            'name'              => 'Admin Delete',
            'slug'              => 'admin-delete',
            'description'       => 'Admin Delete Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 19
        ]);
        Permission::firstOrCreate([
            'name'              => 'Permission Create',
            'slug'              => 'permission-create',
            'description'       => 'Permission Create Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 20
        ]);
        Permission::firstOrCreate([
            'name'              => 'Permission Edit',
            'slug'              => 'permission-edit',
            'description'       => 'Permission Edit Description',
            'created_by'       => 1,
            'updated_by'     => 1
        ], [
            'parent_permission_id' => 20
        ]);


    }
}
