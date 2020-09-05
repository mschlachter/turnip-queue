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

Route::redirect('/', '/queue');

Route::name('queue.')->group(function () {
	Route::get('/queue', 'QueueController@index')->name('find');
	Route::post('/queue', 'QueueController@search')->name('find-post');

	Route::middleware(['verified'])->group(function() {
		Route::get('/queue/create', 'QueueController@create')->name('create');
		Route::post('/queue/create', 'QueueController@store')->name('store')->middleware(VerifyRecaptchaMiddleware::class);
		Route::post('/queue/admin/boot-seeker', 'QueueController@bootSeeker')->name('boot-seeker');

		Route::get('/queue/admin/{turnipQueue:token}', 'QueueController@admin')->name('admin');
		Route::post('/queue/admin/{turnipQueue:token}', 'QueueController@update')->name('update');
		Route::post('/queue/admin/{turnipQueue:token}/add-half-hour', 'QueueController@addHalfHour')->name('add-half-hour');
		Route::post('/queue/admin/{turnipQueue:token}/close', 'QueueController@close')->name('close');
	});

	Route::get('/queue/{turnipQueue:token}', 'QueueController@join')->name('join');
	Route::post('/queue/{turnipQueue:token}', 'QueueController@register')->name('register')->middleware(VerifyRecaptchaMiddleware::class);

	Route::get('/queue/{turnipQueue:token}/ping', 'QueueController@ping')->name('ping');
	Route::post('/queue/{turnipQueue:token}/leave', 'QueueController@leave')->name('leave');
});


Route::name('message.')->middleware(['verified'])->group(function() {
	Route::post('message/store', 'MessageController@store')->name('store');
	Route::post('message/destroy/{turnipQueueMessage:id}', 'MessageController@destroy')->name('destroy');
});

Route::name('donate.')->group(function() {
	Route::get('/donate', 'DonationController@index')->name('index');
	Route::get('/donate/thank-you', 'DonationController@thankYou')->name('thank-you');
});

Route::name('terms.')->group(function() {
	Route::get('/terms-and-conditions', 'TermsController@index')->name('index');
});

Route::name('notifications.')->group(function() {
	Route::get('/notifications/dismiss', 'SiteNotificationController@dismiss')->name('dismiss');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
