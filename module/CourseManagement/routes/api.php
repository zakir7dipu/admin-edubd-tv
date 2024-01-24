<?php

use App\Http\Controllers\API\V1\Auth\AuthAPIController;
use Illuminate\Support\Facades\Route;
use Module\CourseManagement\Controllers\API\V1\CourseCategoryController;
use Module\CourseManagement\Controllers\API\V1\CourseController;
use Module\CourseManagement\Controllers\API\V1\InstructorApiController;

Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'account', 'middleware' => 'auth:sanctum'], function () {
        Route::group(['prefix' => 'courses'], function () {
            Route::get('/', [CourseController::class, 'accountCourses']);
            Route::get('topics/lessons/{lesson_id}', [CourseController::class, 'accountCourseTopicLesson']);

        });
        Route::post('/lesson/review', [CourseController::class, 'lessonReview']);
        Route::get('/lesson/review/{lessonId}', [CourseController::class, 'getLessonReview']);
        Route::post('/course/review', [CourseController::class, 'courseReview']);

        Route::get('/lesson/quiz-result-show/{lessonId}/{studentId}', [CourseController::class, 'getLessonResult']);
        Route::post('/lesson/quiz-result', [CourseController::class, 'quizResult']);
        Route::put('/lesson/quiz-result-update/{id}', [CourseController::class, 'quizResultUpdate']);

        Route::get('/lesson/certificates', [CourseController::class, 'getCertificate']);
        Route::get('/lesson/download-certificate/{enrollmentItemId}', [CourseController::class, 'downloadCertificate']);

        Route::get('/lesson/lesson-tracking-show/{studentId}/{courseId}/{lessonId}', [CourseController::class, 'getLessonTracking']);
        Route::post('/lesson/lesson-tracking', [CourseController::class, 'lessonTracking']);

        Route::post('/change-password', [AuthAPIController::class, 'changePassword']);
        Route::post('/upload-image', [AuthAPIController::class, 'updateImage']);
        Route::get('/profile-image', [AuthAPIController::class, 'getImage']);
        Route::post('/profile-update', [AuthAPIController::class, 'updateProfileInformation']);
        Route::get('/profile-info', [AuthAPIController::class, 'getProfileInformation']);
        Route::get('/user-info', [AuthAPIController::class, 'getUser']);

    });

    Route::group(['prefix' => 'courses'], function () {
        Route::get('popular', [CourseController::class, 'popular']);
        Route::get('latest', [CourseController::class, 'latest']);
        Route::get('all-courses', [CourseController::class, 'AllCourse']);
        Route::get('/{slug}', [CourseController::class, 'show']);
        Route::get('/{slug}/introductions', [CourseController::class, 'courseIntroductions']);
        Route::get('/{slug}/instructors', [CourseController::class, 'courseInstructors']);
        Route::get('/{slug}/outcomes', [CourseController::class, 'courseOutcomes']);
        Route::get('/{slug}/faqs', [CourseController::class, 'courseFaqs']);
        Route::get('/{slug}/topics', [CourseController::class, 'courseTopics']);
        Route::get('/{slug}/lessons', [CourseController::class, 'courseContent']);
        Route::get('topic/{topic_id}/lessons', [CourseController::class, 'courseTopicLessons']);
        Route::get('topics/lessons/{fileName}', [CourseController::class, 'downloadPdf']);
        Route::get('search/{title}',[CourseController::class, 'SearchByTitle']);
        Route::get('reviews/{course_id}', [CourseController::class, 'getCourseReview']);


    });

    Route::get('{category_slug}/courses', [CourseController::class, 'coursesByCategory']);

    Route::group(['prefix' => 'course-categories'], function () {
        Route::get('highlighted', [CourseCategoryController::class, 'highlightedCourseCategories']);
        Route::get('parent/show-in-menu', [CourseCategoryController::class, 'showInMenuParentCourseCategories']);
        Route::get('show-in-menu-by-parent/{parent_id}', [CourseCategoryController::class, 'showInMenuByParentCourseCategories']);
        Route::get('/{slug}', [CourseCategoryController::class, 'show']);
    });

    Route::get('course-tags', [CourseController::class, 'courseTags']);
    Route::get('courses-by-tag/{tag_id}', [CourseController::class, 'coursesByTag']);


    Route::group(['prefix' => 'instructor'], function () {
        Route::post('create', [InstructorApiController::class, 'CreateInstructor']);
        Route::get('/{userName}', [InstructorApiController::class, 'ShowInstructors']);
        Route::get('/', [InstructorApiController::class, 'ShowInstructorsAll']);
    });
});
