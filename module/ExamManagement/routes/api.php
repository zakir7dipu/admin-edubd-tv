<?php

use Illuminate\Support\Facades\Route;

use Module\ExamManagement\Controllers\API\V1\ExamCategoryController;
use Module\ExamManagement\Controllers\API\V1\ExamController;

Route::group(['prefix' => 'v1'], function () {

    Route::get('exam-categories', [ExamCategoryController::class, 'examCategories']);
    Route::get('exam-categories/parent', [ExamCategoryController::class, 'parentExamCategories']);
    Route::get('exam-categories/parent/{parent_id}', [ExamCategoryController::class, 'examCategoriesByParent']);

    Route::get('exam-years', [ExamController::class, 'examYears']);
    Route::get('exam-types', [ExamController::class, 'examTypes']);

    Route::get('exams', [ExamController::class, 'exams']);
    Route::get('exams/{slug}', [ExamController::class, 'examDetails']);


    Route::group(['prefix' => 'exam', 'middleware' => 'auth:sanctum'], function () {
        Route::get('exams-by-category/{category_id}', [ExamController::class, 'examsByCategory']);
        Route::get('{slug}/chapter-by-exam', [ExamController::class, 'chapterByExam']);
        Route::get('quizzes-by-chapter/{chapterSlug}', [ExamController::class, 'quizzesBychapterShow']);
        Route::post('exam-quiz-test', [ExamController::class, 'ExamQuizTest']);
        Route::put('exam-quiz-test-quizzes/{quizTestId}/{quizzesId}', [ExamController::class,'ExamQuizTestQuizzes']);
        Route::get('quiz-test/{id}', [ExamController::class, 'getQuizTest']);
        Route::get('exam-quiz-test-quizzes/{quizTestId}', [ExamController::class,'GetExamQuizTestQuizzes']);
    });
});
