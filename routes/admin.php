<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\Auth\RegisterController as AdminRegisterController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController as AdminForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController as AdminResetPasswordController;
use App\Http\Controllers\Admin\CkeditorController as AdminCkeditorController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SliderImageController as AdminSliderImageController;

/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for admin application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

// Admin Open Routes
Route::name('admin.')->prefix('admin')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('get.login');
    Route::post('login', [AdminLoginController::class, 'postLogin'])->name('post.login');
    Route::get('forgot-password', [AdminForgotPasswordController::class, 'showForgotPasswordForm'])->name('get.forgot-password');
    Route::post('forgot-password', [AdminForgotPasswordController::class, 'postForgotPassword'])->name('post.forgot-password');
    Route::get('reset-password/{token}', [AdminResetPasswordController::class, 'showResetPasswordForm'])->name('get.reset-password');
    Route::post('reset-password/{token}', [AdminResetPasswordController::class, 'postResetPassword'])->name('post.reset-password');
    Route::get('register', [AdminRegisterController::class, 'showSignupForm'])->name('get.register');
    Route::post('register', [AdminRegisterController::class, 'processSignup'])->name('post.register');
    Route::get('products/dump-product', [AdminProductController::class, 'dumpProduct'])->name('get.products.dump-product');
    Route::get('products/dump-product-with-companies', [AdminProductController::class, 'dumpProductWithCompanies'])->name('get.products.dump-product-with-companies');
});

// Admin Authenticated Routes
Route::middleware(['auth:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('', [AdminDashboardController::class, 'displayDashboard'])->name('get.dashboard');
    Route::post('logout', [AdminLoginController::class, 'adminPostLogout'])->name('post.logout');

    Route::resource('users', AdminUserController::class);
    Route::post('users/multiple-delete', [AdminUserController::class, 'multipleDelete'])->name('post.users.multiple-delete');
    Route::post('users/multiple-change-status', [AdminUserController::class, 'multipleChangeStatus'])->name('post.users.multiple-change-status');
    Route::post('users/change-status', [AdminUserController::class, 'changeStatus'])->name('post.users.change-status');
    Route::post('users/user-export', [AdminUserController::class, 'ExportUser'])->name('post.users.user-export');
    //Route::get('getUploadImage/{foldername}/{filename}', [AdminDashboardController::class, 'displayUserImage'])->name('image.upload-image');

    Route::resource('pages', AdminPageController::class);
    Route::post('pages/multiple-delete', [AdminPageController::class, 'multipleDelete'])->name('post.pages.multiple-delete');
    Route::post('pages/multiple-change-status', [AdminPageController::class, 'multipleChangeStatus'])->name('post.pages.multiple-change-status');
    Route::post('pages/change-status', [AdminPageController::class, 'changeStatus'])->name('post.pages.change-status');
    Route::post('ckeditor/image-upload', [AdminCkeditorController::class, 'upload'])->name('post.ckeditor.upload');

    Route::resource('slider-images', AdminSliderImageController::class);
    Route::post('slider-images/multiple-delete', [AdminSliderImageController::class, 'multipleDelete'])->name('post.slider-images.multiple-delete');
    Route::post('slider-images/multiple-change-status', [AdminSliderImageController::class, 'multipleChangeStatus'])->name('post.slider-images.multiple-change-status');
    Route::post('slider-images/change-status', [AdminSliderImageController::class, 'changeStatus'])->name('post.slider-images.change-status');

    Route::resource('products', AdminProductController::class);
    Route::post('products/multiple-delete', [AdminProductController::class, 'multipleDelete'])->name('post.products.multiple-delete');
    Route::post('products/multiple-change-status', [AdminProductController::class, 'multipleChangeStatus'])->name('post.products.multiple-change-status');
    Route::post('products/change-status', [AdminProductController::class, 'changeStatus'])->name('post.products.change-status');

    Route::resource('inquiries', AdminInquiryController::class);
    Route::post('inquiries/multiple-delete', [AdminInquiryController::class, 'multipleDelete'])->name('post.inquiries.multiple-delete');
});
