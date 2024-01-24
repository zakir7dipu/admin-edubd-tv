<?php

use Illuminate\Support\Facades\Route;
use Module\WebsiteCMS\Controllers\API\V1\AboutController;
use Module\WebsiteCMS\Controllers\API\V1\BecomeInstructorApiController;
use Module\WebsiteCMS\Controllers\API\V1\BlogApiController;
use Module\WebsiteCMS\Controllers\API\V1\FaqsApiController;
use Module\WebsiteCMS\Controllers\API\V1\PrivacyPolicyApiController;
use Module\WebsiteCMS\Controllers\API\V1\ReturnAndRefundApiController;
use Module\WebsiteCMS\Controllers\API\V1\SiteInfoController;
use Module\WebsiteCMS\Controllers\API\V1\SliderController;
use Module\WebsiteCMS\Controllers\API\V1\SocialLinkController;
use Module\WebsiteCMS\Controllers\API\V1\SubscriberController;
use Module\WebsiteCMS\Controllers\API\V1\SupportApiController;
use Module\WebsiteCMS\Controllers\API\V1\TermsAndConditonApiController;
use Module\WebsiteCMS\Controllers\API\V1\TestimonialController;

Route::group(['prefix' => 'v1'], function () {
    Route::get('site-info', SiteInfoController::class);
    Route::get('support', SupportApiController::class);
    Route::get('terms-and-condition',TermsAndConditonApiController::class);
    Route::get('return-and-refund',ReturnAndRefundApiController::class);
    Route::get('privacy-policy',PrivacyPolicyApiController::class);
    Route::get('become-instructor',BecomeInstructorApiController::class);
    Route::get('sliders', SliderController::class);
    Route::get('blogs', BlogApiController::class);
    Route::get('blogs/{slug}', [BlogApiController::class, 'show']);
    Route::get('faqs', FaqsApiController::class);
    Route::get('testimonials', TestimonialController::class);
    Route::get('about', AboutController::class);
    Route::get('social-links', SocialLinkController::class);

    Route::group(['prefix' => 'subscribers'], function () {
        Route::post('store', [SubscriberController::class, 'store']);
        Route::post('verify/{verify_token}/{hash_email}', [SubscriberController::class, 'verify']);
    });
});
