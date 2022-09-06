<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyRecaptchaMiddleware;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\InfoController;
use \App\Http\Controllers\QueueController;
use \App\Http\Controllers\ProfileController;
use \App\Http\Controllers\MessageController;
use \App\Http\Controllers\DonationController;
use \App\Http\Controllers\TermsController;
use \App\Http\Controllers\SiteNotificationController;
use \App\Http\Controllers\SitemapController;

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

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::name('queue.')->group(function () {
    Route::get('/queue', [QueueController::class, 'index'])->name('find');
    Route::post('/queue', [QueueController::class, 'search'])->name('find-post');

    Route::middleware(['verified'])->group(function () {
        Route::get('/queue/create', [QueueController::class, 'create'])->name('create');
        Route::post('/queue/create', [QueueController::class, 'store'])->name('store')
        ->middleware(VerifyRecaptchaMiddleware::class);
        Route::post('/queue/admin/boot-seeker', [QueueController::class, 'bootSeeker'])->name('boot-seeker');

        Route::get('/queue/admin/{turnipQueue:token}', [QueueController::class, 'admin'])->name('admin');
        Route::post('/queue/admin/{turnipQueue:token}', [QueueController::class, 'update'])->name('update');
        Route::get('/queue/admin/{turnipQueue:token}/current-queue', [QueueController::class, 'getCurrentQueue'])
        ->name('current-queue');
        Route::post('/queue/admin/{turnipQueue:token}/add-half-hour', [QueueController::class, 'addHalfHour'])
        ->name('add-half-hour');
        Route::post('/queue/admin/{turnipQueue:token}/close', [QueueController::class, 'close'])->name('close');
    });

    Route::get('/queue/{turnipQueue:token}', [QueueController::class, 'join'])->name('join');
    Route::post('/queue/{turnipQueue:token}', [QueueController::class, 'register'])->name('register')
    ->middleware(VerifyRecaptchaMiddleware::class);

    Route::get('/queue/{turnipQueue:token}/get-seeker-status', [QueueController::class, 'getSeekerStatus'])
    ->name('get-status');
    Route::post('/queue/{turnipQueue:token}/leave', [QueueController::class, 'leave'])->name('leave');
});

Route::name('profile.')->middleware('auth')->prefix('profile/')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::post('/', [ProfileController::class, 'update'])->name('update');
    Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('delete');
});


Route::name('message.')->middleware(['verified'])->group(function () {
    Route::post('message/store', [MessageController::class, 'store'])->name('store');
    Route::post('message/destroy/{turnipQueueMessage:id}', [MessageController::class, 'destroy'])->name('destroy');
});

Route::name('info.')->group(function() {
    Route::get('/faq', [InfoController::class, 'faq'])->name('faq');
    Route::get('/contact', [InfoController::class, 'contact'])->name('contact');
    Route::post('/contact', [InfoController::class, 'sendMessage'])->name('send-message')->middleware(VerifyRecaptchaMiddleware::class);
});

Route::name('donate.')->group(function () {
    Route::get('/donate', [DonationController::class, 'index'])->name('index');
    Route::get('/donate/thank-you', [DonationController::class, 'thankYou'])->name('thank-you');
});

Route::name('terms.')->group(function () {
    Route::get('/terms-and-conditions', [TermsController::class, 'index'])->name('index');
});

Route::name('notifications.')->group(function () {
    Route::get('/notifications/dismiss', [SiteNotificationController::class, 'dismiss'])->name('dismiss');
});

Auth::routes(['verify' => true]);

Route::redirect('/home', '/queue/create')->name('home')->middleware('verified');

Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
