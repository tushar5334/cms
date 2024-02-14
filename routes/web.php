<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get(
    'init-settings',
    function () {
    }
);
Route::get('/check-email', function () {
    $mailTo['to'] = array(
        array(
            'email' => 'tushar5334@gmail.com',
            'display_name' => 'Tushar Patil'
        )
    );
    $data = array(
        'siteurl' => getenv('APP_URL'),
        'mailcontent' => array(
            'name' => 'Tushar Patil',
            'reset_url' => route('admin.get.reset-password', 'XXXXXXXXXXXX'), //url('/').'/admin/reset-password/'.$autoResetToken,
            'message' => 'Password has been reseted sucessfully.',
        )
    );
    return view('admin.email_template.reset_password', $data);
});
