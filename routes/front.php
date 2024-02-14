<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\PageController;

/* Route::get(
    '/',
    function () {
        return "Hello....";
    }
); */

// Front Open Routes
Route::name('front.')->prefix('/')->group(function () {
    Route::get('', [PageController::class, 'index'])->name('get.home-page');
    Route::get('by-category', [PageController::class, 'getProductByCategory'])->name('get.by-category');
    Route::get('by-segment', [PageController::class, 'getProductBySegment'])->name('get.by-segment');
    Route::get('enquiry', [PageController::class, 'getEnquiry'])->name('get.enquiry');
    Route::post('enquiry', [PageController::class, 'postEnquiry'])->name('post.enquiry');
    Route::get('{page_slug?}', [PageController::class, 'getInnerPageContent'])->name('get.inner-page');
});
