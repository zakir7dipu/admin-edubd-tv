<?php

use Illuminate\Support\Facades\Route;
use Module\CourseManagement\Controllers\CourseCategoryController;
use Module\CourseManagement\Controllers\CourseController;
use Module\CourseManagement\Controllers\CourseLessonQuizController;
use Module\CourseManagement\Controllers\InstructorController;
use Module\CourseManagement\Controllers\StudentController;

Route::group(['prefix' => 'course-management', 'as' => 'cm.'], function () {

    Route::resource('course-categories', CourseCategoryController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('instructors', InstructorController::class);
    Route::resource('students', StudentController::class);
    Route::resource('lesson-quiz', CourseLessonQuizController::class);
    Route::delete('delete-quiz-option/{option_id}', [CourseLessonQuizController::class, 'deleteQuizOption'])->name('delete-quiz-option');


    Route::match(['GET', 'POST'], 'courses/{id}/introductions-update-or-create',        [CourseController::class, 'introductionsUpdateOrCreate'])->name('courses.introductions-update-or-create');
    Route::match(['GET', 'POST'], 'courses/{id}/intro-video',                           [CourseController::class, 'introVideo'])->name('courses.intro-video');
    Route::match(['GET', 'POST'], 'courses/{id}/instructors-update-or-create',          [CourseController::class, 'instructorsUpdateOrCreate'])->name('courses.instructors-update-or-create');
    Route::match(['GET', 'POST'], 'courses/{id}/outcomes-update-or-create',             [CourseController::class, 'outcomesUpdateOrCreate'])->name('courses.outcomes-update-or-create');
    Route::match(['GET', 'POST'], 'courses/{id}/faqs-update-or-create',                 [CourseController::class, 'faqsUpdateOrCreate'])->name('courses.faqs-update-or-create');
    Route::match(['GET', 'POST'], 'courses/{id}/topics-update-or-create',               [CourseController::class, 'topicsUpdateOrCreate'])->name('courses.topics-update-or-create');
    Route::match(['GET', 'POST'], 'courses/{id}/lessons-update-or-create',              [CourseController::class, 'lessonsUpdateOrCreate'])->name('courses.lessons-update-or-create');
    Route::match(['GET', 'POST'], 'courses/{id}/upload',                                [CourseController::class, 'upload'])->name('courses.upload');
    Route::match(['GET', 'POST'], 'courses/{id}/publish',                               [CourseController::class, 'publish'])->name('courses.publish');


    Route::delete('delete-topic/{id}', [CourseController::class, 'deleteTopic'])->name('delete-topic');
    Route::delete('delete-lesson/{id}', [CourseController::class, 'deleteLesson'])->name('delete-lesson');


    Route::post('file-upload', [CourseController::class, 'fileUpload'])->name('file-upload');
    Route::post('intor-file-upload', [CourseController::class, 'introFileUpload'])->name('intor-file-upload');
    Route::post('store-youtube-embed-link', [CourseController::class, 'storeYoutubeEmbedLink'])->name('store-youtube-embed-link');
    Route::post('store-intro-youtube-embed-link', [CourseController::class, 'storeIntroYoutubeEmbedLink'])->name('store-intro-youtube-embed-link');
    Route::post('all-link', [CourseController::class, 'storeAllLink'])->name('all-link');
    Route::post('intro-all-link', [CourseController::class, 'storeIntroAllLink'])->name('intro-all-link');
    Route::post('insert-or-update-attachment', [CourseController::class, 'insertOrUpdateAttachment'])->name('insert-or-update-attachment');

});
