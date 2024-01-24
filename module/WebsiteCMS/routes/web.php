<?php

use Illuminate\Support\Facades\Route;
use Module\WebsiteCMS\Controllers\AboutController;
use Module\WebsiteCMS\Controllers\BecomeInstructorController;
use Module\WebsiteCMS\Controllers\BlogCategoryController;
use Module\WebsiteCMS\Controllers\BlogController;
use Module\WebsiteCMS\Controllers\FaqsController;
use Module\WebsiteCMS\Controllers\PageController;
use Module\WebsiteCMS\Controllers\PrivacyPolicyController;
use Module\WebsiteCMS\Controllers\ReturnAndRefundPolicyController;
use Module\WebsiteCMS\Controllers\SiteInfoController;
use Module\WebsiteCMS\Controllers\SliderController;
use Module\WebsiteCMS\Controllers\SocialLinkController;
use Module\WebsiteCMS\Controllers\SubscriberController;
use Module\WebsiteCMS\Controllers\SupportController;
use Module\WebsiteCMS\Controllers\TermsAndConditionController;
use Module\WebsiteCMS\Controllers\TestimonialsController;


Route::group(['prefix' => 'website-cms', 'as' => 'wc.'], function () {

    Route::resource('sliders', SliderController::class);
    Route::resource('social-links', SocialLinkController::class);
    Route::resource('testimonials', TestimonialsController::class);
    Route::resource('faqs', FaqsController::class);
    Route::resource('pages', PageController::class);
    Route::resource('siteinfo', SiteInfoController::class);
    Route::resource('about', AboutController::class);
    Route::resource('blog-category', BlogCategoryController::class);
    Route::resource('blog', BlogController::class);
    Route::resource('support', SupportController::class);
    Route::resource('terms-and-condition', TermsAndConditionController::class);
    Route::resource('privacy-policy', PrivacyPolicyController::class);
    Route::resource('return-refund-policy', ReturnAndRefundPolicyController::class);
    Route::resource('become-instructor', BecomeInstructorController::class);
    Route::resource('subscribers', SubscriberController::class);
});


Route::get('subscriber/export/', [SubscriberController::class, 'Export'])->name('export');

// extra

Route::get('/get-course', [SliderController::class, 'getCourse'])->name('get-course');
