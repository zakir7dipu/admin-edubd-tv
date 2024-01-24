<?php


use Illuminate\Support\Facades\Route;
use Module\ExamManagement\Controllers\ExamCategoryController;
use Module\ExamManagement\Controllers\ExamController;
use Module\ExamManagement\Controllers\ExamInstituteController;
use Module\ExamManagement\Controllers\ExamQuizController;
use Module\ExamManagement\Controllers\ExamTypeController;
use Module\ExamManagement\Controllers\ExamYearController;

Route::group(['prefix' => 'exam-management', 'as' => 'em.'], function () {
     Route::resource('exam-categories', ExamCategoryController::class);
     Route::resource('exam-types', ExamTypeController::class);
     Route::resource('exam-years', ExamYearController::class);
     Route::resource('institutes', ExamInstituteController::class);
     Route::resource('exams', ExamController::class);
     Route::delete('delete-exam-chapter/{chapter_id}', [ExamController::class, 'deleteExamChapter'])->name('delete-exam-chapter');
     Route::resource('exam-quizzes', ExamQuizController::class);

     Route::delete('delete-quiz-option/{option_id}', [ExamQuizController::class, 'deleteQuizOption'])->name('delete-quiz-option');
     Route::match(['GET', 'POST'], 'exam/{id}/publish-update-or-create', [ExamController::class, 'publishUpdateOrCreate'])->name('exams.publish-update-or-create');
});


Route::get('fetch-exams/{exam_category_id}', [ExamQuizController::class,'fetchExams'])->name('fetch-exams');
Route::get('fetch-chapters/{exam_id}',       [ExamQuizController::class,'fetchExamChapters'])->name('fetch-chapters');
