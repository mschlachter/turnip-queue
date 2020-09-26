<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyRecaptchaMiddleware;

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

Route::get('/', 'HomeController@index')->name('index');

Route::name('queue.')->group(function () {
    Route::get('/queue', 'QueueController@index')->name('find');
    Route::post('/queue', 'QueueController@search')->name('find-post');

    Route::middleware(['verified'])->group(function () {
        Route::get('/queue/create', 'QueueController@create')->name('create');
        Route::post('/queue/create', 'QueueController@store')->name('store')
        ->middleware(VerifyRecaptchaMiddleware::class);
        Route::post('/queue/admin/boot-seeker', 'QueueController@bootSeeker')->name('boot-seeker');

        Route::get('/queue/admin/{turnipQueue:token}', 'QueueController@admin')->name('admin');
        Route::post('/queue/admin/{turnipQueue:token}', 'QueueController@update')->name('update');
        Route::post('/queue/admin/{turnipQueue:token}/add-half-hour', 'QueueController@addHalfHour')
        ->name('add-half-hour');
        Route::post('/queue/admin/{turnipQueue:token}/close', 'QueueController@close')->name('close');
    });

    Route::get('/queue/{turnipQueue:token}', 'QueueController@join')->name('join');
    Route::post('/queue/{turnipQueue:token}', 'QueueController@register')->name('register')
    ->middleware(VerifyRecaptchaMiddleware::class);

    Route::get('/queue/{turnipQueue:token}/ping', 'QueueController@ping')->name('ping');
    Route::get('/queue/{turnipQueue:token}/get-seeker-status', 'QueueController@getSeekerStatus')
    ->name('get-status');
    Route::post('/queue/{turnipQueue:token}/leave', 'QueueController@leave')->name('leave');
});

Route::name('profile.')->middleware('auth')->prefix('profile/')->group(function () {
    Route::get('/', 'ProfileController@show')->name('show');
    Route::post('/', 'ProfileController@update')->name('update');
    Route::post('/update-password', 'ProfileController@updatePassword')->name('update-password');
    Route::delete('/', 'ProfileController@destroy')->name('delete');
});


Route::name('message.')->middleware(['verified'])->group(function () {
    Route::post('message/store', 'MessageController@store')->name('store');
    Route::post('message/destroy/{turnipQueueMessage:id}', 'MessageController@destroy')->name('destroy');
});

Route::name('donate.')->group(function () {
    Route::get('/donate', 'DonationController@index')->name('index');
    Route::get('/donate/thank-you', 'DonationController@thankYou')->name('thank-you');
});

Route::name('terms.')->group(function () {
    Route::get('/terms-and-conditions', 'TermsController@index')->name('index');
});

Route::name('notifications.')->group(function () {
    Route::get('/notifications/dismiss', 'SiteNotificationController@dismiss')->name('dismiss');
});

Auth::routes(['verify' => true]);

Route::redirect('/home', '/queue/create')->name('home')->middleware('verified');
